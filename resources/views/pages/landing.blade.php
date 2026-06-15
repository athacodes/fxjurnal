<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FxJournals - Forex Trading Journal & Signals</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-blue-50/30 text-gray-900 font-sans flex flex-col min-h-screen">

    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center bg-white shadow-sm rounded-b-2xl border-b border-blue-100 w-full">
        <div class="text-2xl font-black text-blue-600 tracking-wider">FxJournals</div>
        <div class="flex items-center space-x-6">
            <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-blue-600 transition">Sign in</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 shadow-md shadow-blue-200 transition">Create account</a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto text-center mt-24 px-6 flex-grow">
        <div class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-6">
            #1 Trusted Trading Journal & Signal Platform
        </div>

        <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-[1.1] tracking-tight">
            Forex trading journal <br>
            <span class="text-blue-600">that makes you profitable</span>
        </h1>

        <p class="mt-8 text-lg md:text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
            The most advanced forex trading journal that automatically tracks every trade, combines premium analyst signals, and reveals the precise patterns that separate profitable traders from the rest.
        </p>

        <div class="mt-12">
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-10 py-5 rounded-2xl font-black text-xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:scale-105 transition transform active:scale-95">
                Get Started for Free &rarr;
            </a>
        </div>

        <div class="mt-12 flex flex-wrap justify-center items-center gap-6 text-sm font-bold text-gray-400 mb-20">
            <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-blue-50">
                <span class="text-yellow-400 mr-2">⭐⭐⭐⭐⭐</span>
                <span class="text-gray-700">5.0 Rating</span>
            </div>
            <div class="h-1 w-1 bg-blue-300 rounded-full"></div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-blue-50 text-gray-700">
                Used by 1,000+ active traders
            </div>
            <div class="h-1 w-1 bg-blue-300 rounded-full"></div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-blue-50 text-gray-700">
                No credit card required
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-blue-100 mt-auto w-full">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Core Features</h3>
                <ul class="mt-4 space-y-2.5 text-sm font-medium text-gray-600">
                    <li><a href="#" class="hover:text-blue-600 transition">Automated Journal</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Pips Auto Calculator</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Profit & Loss Analytics</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Chart Attachment</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Community</h3>
                <ul class="mt-4 space-y-2.5 text-sm font-medium text-gray-600">
                    <li><a href="#" class="hover:text-blue-600 transition">Admin Trading Signals</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Market Session Tracker</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Performance Review</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Legal</h3>
                <ul class="mt-4 space-y-2.5 text-sm font-medium text-gray-600">
                    <li><a href="#" class="hover:text-blue-600 transition">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Security Standarization</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Contact</h3>
                <ul class="mt-4 space-y-2.5 text-sm font-medium text-gray-600">
                    <li><a href="mailto:support@fxjournals.com" class="hover:text-blue-600 transition text-blue-600 break-all">support@fxjournals.com</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 py-6 border-t border-blue-50 text-center text-xs font-medium text-gray-400">
            &copy; 2026 FxJournals. All rights reserved.
        </div>
    </footer>

</body>
</html>
