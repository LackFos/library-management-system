@extends('index')

@section('page')
    <div class="flex flex-col gap-6 p-6">
        <form class="flex gap-4">
            <input
                placeholder="Cari nama atau isbn"
                type="text"
                name="search"
                class='h-12 w-full rounded-full border bg-white px-4 text-sm shadow-sm outline-none focus:border-[#6da099] focus:shadow-md'
            >

            <button
                type="submit"
                class='whitespace-nowrap rounded-full bg-[#6da099] px-6 text-sm font-bold text-white shadow-md'
            >Cari Buku</button>
        </form>

        @isset($keyword)
            <h>Hasil pencarian untuk "{{ $keyword }}"</h3>
            @endisset

            <div class="grid grid-cols-2 gap-4">
                @foreach ($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>

            <a
                href="/pinjam"
                class="flex h-10 w-full items-center justify-center rounded-full bg-[#6da099] text-sm font-bold text-white"
            >Lanjutkan</a>
    </div>

    <script>
        const $cards = document.querySelectorAll('.book-card')

        $cards.forEach(($card) => {
            const cart = JSON.parse(localStorage.getItem('cart')) || []

            if (cart.some((item) => item.id === $card.dataset.bookId)) {
                $card.querySelector(".add-button").style.display = "none"
                $card.querySelector(".remove-button").style.display = "flex"
            } else {
                $card.querySelector(".add-button").style.display = "flex"
                $card.querySelector(".remove-button").style.display = "none"
            }
        })

        function addProduct({
            id,
            name,
            image
        }) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            const isItemOnCart = cart.find((item) => item.id == id)

            if (isItemOnCart) return

            localStorage.setItem('cart', JSON.stringify([...cart, {
                id,
                name,
                image
            }]));

            $card = document.querySelector(`[data-book-id='${id}']`)
            $card.querySelector(".add-button").style.display = "none"
            $card.querySelector(".remove-button").style.display = "flex"
        }

        function removeProduct(id) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            const updatedCart = cart.filter((item) => (item.id != id));

            localStorage.setItem('cart', JSON.stringify(updatedCart));

            $card = document.querySelector(`[data-book-id='${id}']`)
            $card.querySelector(".add-button").style.display = "flex"
            $card.querySelector(".remove-button").style.display = "none"
        }
    </script>
@endsection
