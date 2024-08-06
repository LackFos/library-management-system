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
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="">
        <aside class='fixed flex h-full w-60 flex-col gap-4 border-r border-gray-200 bg-white'>
            <div class="flex w-full px-4 py-6">
                <div class="max-w-[160px]">
                    <x-site-logo />
                </div>
            </div>
            <ul class="flex w-full flex-col gap-4 px-4">
                <li>
                    <a
                        href="/"
                        class="flex h-12 w-full items-center gap-4 rounded-full px-4 text-sm font-semibold hover:bg-gray-200"
                    >
                        <x-icons.analytics /> Dashboard
                    </a>
                </li>

                <li>
                    <a
                        href="/pengembalian"
                        class="flex h-12 w-full items-center gap-4 rounded-full px-4 text-sm font-semibold hover:bg-gray-200"
                    >
                        <x-icons.swap /> Pengembalian
                    </a>
                </li>

                <div class="flex flex-col gap-1">
                    <li
                        href="/buku"
                        class="flex h-12 w-full items-center gap-4 rounded-full px-4 text-sm font-semibold"
                    >
                        <x-icons.book /> Buku
                    </li>
                    <li>
                        <a
                            href="/buku"
                            class="flex h-10 w-full items-center gap-4 rounded-full pl-14 pr-4 text-xs font-semibold hover:bg-gray-200"
                        >
                            Daftar Buku
                        </a>
                    </li>
                    <li>
                        <a
                            href="/buku/tambah"
                            class="flex h-10 w-full items-center gap-4 rounded-full pl-14 pr-4 text-xs font-semibold hover:bg-gray-200"
                        >
                            Tambah Buku
                        </a>
                    </li>
                </div>
            </ul>
        </aside>

        <main class="min-h-full w-full pl-60">
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

            @yield('page')
        </main>
    </div>
</body>
<script>
    const notification = document.querySelector(".notification")
    if (notification) {
        setTimeout(() => {
            notification.remove()
        }, 5000)
    }
</script>

</html>
