<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body>
    <form
        action="/login"
        method="POST"
    >
        @csrf

        @if (session('success'))
            <div class="notification w-full px-6 pt-6">
                <div
                    class="min-w-40 flex items-center justify-between rounded-xl border border-green-600 bg-green-200 p-4 text-sm font-bold text-green-600">
                    {{ session('success') }}

                    <div onclick="this.parentNode.remove();">
                        <x-icons.close />
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="notification w-full px-6 pt-6">
                <div
                    class="min-w-40 flex items-center justify-between rounded-xl border border-red-600 bg-red-200 p-4 text-sm font-bold text-red-600">
                    {{ session('error') }}

                    <div onclick="this.parentNode.remove();">
                        <x-icons.close />
                    </div>
                </div>
            </div>
        @endif
        <div class="min-w-screen relative flex min-h-screen items-center justify-center bg-[#e6e6e6]">
            <div class="flex w-[300px] flex-col gap-2 rounded-xl bg-white p-6">
                <h2 class="pb-4">Login</h2>
                <input
                    value="{{ old('email') }}"
                    placeholder="Email"
                    type="text"
                    name="email"
                    class='h-10 w-full rounded-full border bg-white px-4 text-sm shadow-sm outline-none focus:border-[#6da099] focus:shadow-md'
                >
                <input
                    placeholder="Password"
                    type="password"
                    name="password"
                    class='h-10 w-full rounded-full border bg-white px-4 text-sm shadow-sm outline-none focus:border-[#6da099] focus:shadow-md'
                >

                <button class="mt-4 h-10 w-full rounded-full bg-[#6da099] text-sm font-bold text-white">Login</button>
            </div>
        </div>
    </form>
</body>

</html>
