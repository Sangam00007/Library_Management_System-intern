<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Guidelines - LibraryMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">
    <div class="max-w-4xl mx-auto px-4 py-16 flex-1 w-full">
        <div class="mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Home
            </a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-12">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-8">Safety Guidelines</h1>
            
            <div class="space-y-6 text-slate-600 leading-relaxed">
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">1. Account Security</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Always use a strong, unique password for your LibraryMS account.</li>
                        <li>Never share your login credentials with anyone.</li>
                        <li>Log out of your account when using public or shared computers.</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">2. Book Handling & Care</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Handle all library books with clean hands.</li>
                        <li>Keep books away from food, liquids, and extreme weather conditions.</li>
                        <li>Do not write, highlight, or fold pages in library books.</li>
                        <li>Report any pre-existing damage to a book immediately upon borrowing it.</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">3. Library Etiquette</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Return books on or before the due date to ensure fair access for all members.</li>
                        <li>Respect other members' privacy and do not attempt to access others' borrowing history.</li>
                    </ul>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">4. Digital Safety</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>We will never ask for your password via email or phone.</li>
                        <li>Ensure you are on the official LibraryMS website before entering your credentials.</li>
                    </ul>
                </section>
            </div>
            
            <div class="mt-12 pt-6 border-t border-slate-100 text-sm text-slate-400">
                Last updated: {{ date('F j, Y') }}
            </div>
        </div>
    </div>
</body>
</html>
