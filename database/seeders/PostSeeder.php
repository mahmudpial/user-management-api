<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create(['role' => 'admin']);
        $category = Category::first() ?? Category::create(['name' => 'Technology', 'slug' => 'technology']);
        $tags = Tag::limit(5)->get();

        $post = Post::create([
            'title' => 'Getting Started with Vue 3 and Modern Web Development',
            'slug' => 'getting-started-with-vue-3',
            'body' => $this->getSamplePostBody(),
            'image' => 'https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=800&q=80',
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'status' => 'published',
            'views' => 0,
        ]);

        if ($tags->count() > 0) {
            $post->tags()->attach($tags->pluck('id')->toArray());
        }
    }

    private function getSamplePostBody(): string
    {
        return <<<'HTML'
<h2>Introduction to Vue 3</h2>

<p>Vue 3 is a modern JavaScript framework for building user interfaces with a focus on simplicity and performance. In this comprehensive guide, we'll explore the key features and best practices for getting started with Vue 3.</p>

<img src="https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=600&q=80" alt="Vue 3 Framework" style="max-width:100%; border-radius:12px; margin:1.5rem auto; display:block;">

<h3>What is Vue 3?</h3>

<p>Vue is a <strong>progressive JavaScript framework</strong> that makes building interactive user interfaces straightforward. Whether you're building a simple widget or a complex single-page application, Vue scales with you.</p>

<h3>Installation and Setup</h3>

<p>The easiest way to get started with Vue 3 is to use Vite. First, make sure you have Node.js installed on your machine.</p>

<pre><code>npm create vite@latest my-vue-project -- --template vue
cd my-vue-project
npm install
npm run dev</code></pre>

<p>Your development server will start at <code>http://localhost:5173</code>. You can now start building your Vue components!</p>

<h3>Core Concepts</h3>

<blockquote>
  <p>Understanding Vue 3's core concepts will help you write better components and manage your application state more effectively.</p>
</blockquote>

<h4>1. Reactive Data with Composition API</h4>

<p>The Composition API is the modern way to write Vue components. Here's a simple example:</p>

<pre><code>&lt;template&gt;
  &lt;div&gt;
    &lt;h1&gt;{{ message }}&lt;/h1&gt;
    &lt;p&gt;Count: {{ count }}&lt;/p&gt;
    &lt;button @click="increment"&gt;Increment&lt;/button&gt;
  &lt;/div&gt;
&lt;/template&gt;

&lt;script setup&gt;
import { ref } from 'vue'

const message = ref('Hello, Vue 3!')
const count = ref(0)

function increment() {
  count.value++
}
&lt;/script&gt;</code></pre>

<h4>2. Component Props and Events</h4>

<p>Components communicate through props (downward) and events (upward):</p>

<pre><code>&lt;template&gt;
  &lt;button @click="$emit('increment')"&gt;Increment&lt;/button&gt;
&lt;/template&gt;

&lt;script setup&gt;
defineProps(['modelValue'])
defineEmits(['increment'])
&lt;/script&gt;</code></pre>

<h3>Best Practices</h3>

<ul>
  <li><strong>Use Single File Components:</strong> Keep template, script, and styles in one file</li>
  <li><strong>Keep Components Small:</strong> Create reusable, focused components</li>
  <li><strong>Use the Composition API:</strong> Write more maintainable code with composition</li>
  <li><strong>Proper State Management:</strong> Use Pinia for complex state</li>
  <li><strong>Performance Optimization:</strong> Use lazy loading and code splitting</li>
</ul>

<h3>Common Patterns</h3>

<p>Here are some common patterns you'll encounter:</p>

<table>
  <thead>
    <tr>
      <th>Pattern</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>v-if / v-else</code></td>
      <td>Conditional rendering</td>
    </tr>
    <tr>
      <td><code>v-for</code></td>
      <td>List rendering</td>
    </tr>
    <tr>
      <td><code>v-bind</code></td>
      <td>Dynamic attribute binding</td>
    </tr>
    <tr>
      <td><code>v-on / @</code></td>
      <td>Event handling</td>
    </tr>
    <tr>
      <td><code>v-model</code></td>
      <td>Two-way binding</td>
    </tr>
  </tbody>
</table>

<h3>Resources and Learning</h3>

<p>To deepen your Vue 3 knowledge, check out these <em>excellent resources</em>:</p>

<ul>
  <li><a href="https://vuejs.org" target="_blank">Official Vue 3 Documentation</a> - The complete reference guide</li>
  <li><a href="https://router.vuejs.org" target="_blank">Vue Router</a> - Client-side routing for SPAs</li>
  <li><a href="https://pinia.vuejs.org" target="_blank">Pinia</a> - The official state management library</li>
  <li><a href="https://www.vuemastery.com" target="_blank">Vue Mastery</a> - Video courses and tutorials</li>
</ul>

<h3>Conclusion</h3>

<p>Vue 3 provides a powerful yet approachable way to build modern web applications. Start with the basics, practice regularly, and gradually incorporate advanced features as you become more comfortable with the framework.</p>

<p><strong>Happy coding!</strong> 🚀 If you have any questions or would like to see more examples, feel free to leave a comment below.</p>

<blockquote>
  <p>The best way to learn Vue 3 is by building projects. Start small and gradually increase complexity as your skills improve.</p>
</blockquote>
HTML;
    }
}
