@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-10 space-y-16">
        <!-- Hero Section -->
        <section class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to BokinceX</h1>
            <p class="text-xl mb-6">Your ultimate online store for all things fashion, tech, and lifestyle!</p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition duration-300 ease-in-out">
                🛍 Store
            </a>
        </section>

        <!-- Categories -->
        <section class="text-white">
            <h2 class="text-2xl font-semibold text-center mb-6">Browse by Category</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach(['Electronics', 'Fashion', 'Home Decor', 'Books', 'Toys', 'Health'] as $category)
                    <a href="#" class="px-6 py-3 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full shadow-md hover:opacity-90">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Testimonials -->
        <section class="bg-white/10 backdrop-blur rounded-lg p-6 text-white">
            <h2 class="text-2xl font-semibold text-center mb-6">What Our Customers Say</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach (['Alex', 'Rita'] as $name)
                    <div class="bg-white/10 p-4 rounded shadow">
                        <p class="italic">“Amazing service and quality products. I love shopping at BokinceX!”</p>
                        <p class="mt-2 font-semibold text-right">- {{ $name }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Newsletter -->
        <section class="text-center text-white">
            <h2 class="text-2xl font-semibold mb-4">Stay Updated</h2>
            <p class="mb-4">Join our newsletter and never miss a deal!</p>
            <form action="#" method="POST" class="flex justify-center gap-4 flex-wrap">
                <input type="email" name="email" placeholder="Enter your email"
                       class="px-4 py-2 rounded-lg bg-white/80 text-black focus:outline-none">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    Subscribe
                </button>
            </form>
        </section>

        <!-- Social Media -->
        <section class="text-center text-white">
            <h2 class="text-2xl font-semibold mb-4">Follow Us</h2>
            <div class="flex justify-center gap-6 text-2xl">
                <a href="#" class="hover:text-blue-500"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-pink-500"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-red-500"><i class="fab fa-youtube"></i></a>
            </div>
        </section>
    </div>

    <!-- Optional: Footer -->
    <footer class="text-center text-white mt-12 py-4 text-sm opacity-75">
        &copy; {{ date('Y') }} BokinceX. All rights reserved.
    </footer>

    <!-- FontAwesome for social icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
@endsection
