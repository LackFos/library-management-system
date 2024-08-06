@extends('index')

@section('page')
    <form
        action="/pinjam"
        method="POST"
        class="p-10"
    >
        @csrf
        <div class="pb-10">
            <h1>Konfirmasi Peminjaman</h1>
        </div>

        <div
            id="container"
            class="grid grid-cols-2 gap-4"
        >

        </div>

        <button
            type="submit"
            class="mt-6 h-10 w-full rounded-full bg-[#6da099] text-sm font-bold text-white"
        >Pinjam Sekarang</button>
    </form>

    <script>
        const cardTemplate = (id, name, image) => {
            return `<div class="flex w-full gap-6 rounded-3xl border border-gray-300 bg-white p-4 transition-shadow hover:shadow-md">
                <input type="hidden" name="book_id[]" value=${id} />
                <div class="relative h-32 w-32 overflow-hidden rounded-2xl bg-gray-300">
                    <img class="absolute left-0 top-0 h-full w-full object-cover" src="${image}" alt="${name}">
                </div>

                <div class="flex w-[calc(100%-160px)] justify-between">
                    <div class="flex flex-col items-start gap-6">
                        <div class="flex flex-col gap-1">
                            <h4>${name}</h4>
                        </div>
                    </div>
                </div>
            </div>`
        }

        $container = document.querySelector('#container')

        cart = JSON.parse(localStorage.getItem('cart')) || []

        $container.innerHTML = cart.map((item) => cardTemplate(item.id, item.name, item.image)).join("")
    </script>
@endsection
