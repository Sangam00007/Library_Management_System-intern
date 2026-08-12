<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - LibraryMS</title>
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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-8">Privacy Policy</h1>
            
            <div class="space-y-6 text-slate-600 leading-relaxed">
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">1. Information We Collect</h2>
                    <p>When you register for an account, we collect personal information such as your name, email address, and contact details. We also track your borrowing history to provide you with better services.</p>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">2. How We Use Your Information</h2>
                    <p>We use your information to manage your account, process book borrowings and returns, calculate fines, and communicate with you regarding your library activity.</p>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">3. Data Security</h2>
                    <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction.</p>
                </section>
                
                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">4. Sharing Your Information</h2>
                    <p>We do not sell or rent your personal information to third parties. We may share information with service providers who assist us in operating our library system, subject to strict confidentiality agreements.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-800 mb-3">5. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us at support@libraryms.com.</p>
                </section>
            </div>
            
            <div class="mt-12 pt-6 border-t border-slate-100 text-sm text-slate-400">
                Last updated: {{ date('F j, Y') }}
            </div>
        </div>
    </div>
</body>
</html>
