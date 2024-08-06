<div
    data-book-id="{{ $book->id }}"
    href="/buku/{{ $book->id }}"
    class="book-card flex w-full gap-6 rounded-3xl border border-gray-300 bg-white p-4 transition-shadow hover:shadow-md"
>
    <div class="relative h-32 w-32 overflow-hidden rounded-2xl bg-gray-300">
        <div
            class="absolute left-1 top-1 z-10 rounded-full border border-black bg-green-200 px-2 py-1 text-xs font-bold text-green-600">
            {{ $book->stock }} pcs</div>

        <x-image
            src="{{ asset($book->image) }}"
            alt="{{ $book->name }}"
        />
    </div>

    <div class="flex w-[calc(100%-160px)] justify-between">
        <div class="flex flex-col items-start gap-6">
            <div class="flex flex-col gap-1">
                <div class="hover:text-[#6da099]">
                    <h4>{{ $book->title }}</h4>
                </div>

                <ul class="flex text-xs font-medium text-gray-400">
                    <li>Romance</li>
                </ul>
            </div>

            <ul class="flex flex-col items-start gap-2">
                {{-- <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                    <x-icons.user />
                    <p>2232068</p>
                </li> --}}
                <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                    <x-icons.pencil />
                    <p>{{ $book->author }}</p>
                </li>
                <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                    <x-icons.barcode />
                    <p>{{ $book->isbn }}</p>
                </li>
            </ul>
        </div>

        <div class="flex flex-col justify-between">
            {{-- <div class="flex items-center gap-2 text-sm">
                <p>Denda: </p>
                <h3 class="text-red-600">Rp 50.000</h3>
            </div> --}}
            <div class="flex flex-col gap-2">
                <div
                    onclick="addProduct({id: '{{ $book->id }}', name: '{{ $book->title }}', image: '{{ $book->image }}'})"
                    href="/buku/{{ $book->id }}"
                    class="add-button flex h-8 items-center justify-center rounded-full border border-blue-600 px-4 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-600 hover:text-white"
                >
                    Pinjam
                </div>
                <div
                    onclick="removeProduct({{ $book->id }})"
                    href="/buku/{{ $book->id }}"
                    class="remove-button flex h-8 items-center justify-center rounded-full border border-red-600 px-4 text-xs font-bold text-red-600 transition-colors hover:bg-red-600 hover:text-white"
                >
                    Batalkan
                </div>
                <a
                    href="/buku/{{ $book->id }}"
                    class="flex h-8 items-center justify-center rounded-full border border-[#6da099] px-4 text-xs font-bold text-[#6da099] transition-colors hover:bg-[#6da099] hover:text-white"
                >
                    Detail
                </a>
            </div>
        </div>
    </div>
</div>
