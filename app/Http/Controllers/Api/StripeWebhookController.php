<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripeCheckoutFulfillment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripeCheckoutFulfillment $fulfillment): JsonResponse
    {
        $secret = (string) config('services.stripe.webhook_secret');
        if ($secret === '') {
            report(new \RuntimeException('STRIPE_WEBHOOK_SECRET is not configured.'));

            return response()->json(['success' => false, 'message' => 'Webhook is not configured.'], 500);
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                $secret,
            );
        } catch (UnexpectedValueException|SignatureVerificationException $exception) {
            return response()->json(['success' => false, 'message' => 'Invalid webhook signature or payload.'], 400);
        }

        if (
            ! in_array($event->type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)
            || ! $event->data->object instanceof Session
        ) {
            $fulfillment->recordIgnoredEvent($event);

            return response()->json(['received' => true]);
        }

        try {
            $fulfillment->processSession(
                $event->data->object,
                $event->id,
                $event->type,
                $event->toArray(),
            );
        } catch (UnprocessableEntityHttpException $exception) {
            $fulfillment->recordRejectedEvent($event);

            return response()->json(['success' => false, 'message' => $exception->getMessage()], 400);
        }

        return response()->json(['received' => true]);
    }
}
