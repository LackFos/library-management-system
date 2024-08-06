@extends('index')

@section('page')
    {{-- <div class="fixed left-0 top-0 z-50 h-full w-full">
        <div
            class="absolute left-1/2 top-1/2 flex w-80 -translate-x-1/2 -translate-y-1/2 flex-col gap-6 rounded-3xl bg-white p-6">
            <h4>Pinjam Buku</h4>

            <div class="flex flex-col gap-4">
                <input
                    placeholder="Tuliskan Member ID"
                    type="text"
                    class='h-10 w-full rounded-full border bg-white px-4 text-sm shadow-sm outline-none focus:border-[#6da099] focus:shadow-md'
                >

                <button class='h-10 whitespace-nowrap rounded-full bg-[#6da099] px-6 text-sm font-bold text-white'>Pinjam
                    Sekarang</button>
            </div>
        </div>

        <div class="h-full w-full bg-black/80"></div>
    </div> --}}

    <div class="flex flex-col gap-6 p-6">
        <div class="flex gap-4">
            <input
                placeholder="Cari member id atau isbn"
                type="text"
                class='h-12 w-full rounded-full border bg-white px-4 text-sm shadow-sm outline-none focus:border-[#6da099] focus:shadow-md'
            >

            <button class='whitespace-nowrap rounded-full bg-[#6da099] px-6 text-sm font-bold text-white shadow-md'>Cari
                Buku</button>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex w-full gap-6 rounded-3xl border border-gray-300 bg-white p-4 transition-shadow hover:shadow-md">
                <a
                    href="/buku/1"
                    class="relative h-32 w-32 overflow-hidden rounded-2xl bg-gray-300"
                >
                    {{-- <x-image
                        src="{{ asset($book->image) }}"
                        alt="{{ $book->name }}"
                    /> --}}
                </a>

                <div class="flex w-[calc(100%-160px)] justify-between">
                    <div class="flex flex-col items-start gap-6">
                        <div class="flex flex-col gap-1">
                            <a
                                href="/buku/1"
                                class="hover:text-[#6da099]"
                            >
                                <h4>Abc</h4>
                            </a>

                            <ul class="flex text-xs font-medium text-gray-400">
                                <li>Romance</li>
                            </ul>
                        </div>

                        <ul class="flex flex-col items-start gap-2">
                            <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                                <x-icons.user />
                                <p>2232068</p>
                            </li>
                            <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                                <x-icons.pencil />
                                <p>Elvis</p>
                            </li>
                            <li class="flex gap-2 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800">
                                <x-icons.barcode />
                                <p>1234566777</p>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-sm">
                            <p>Denda: </p>
                            <h3 class="text-red-600">Rp 50.000</h3>
                        </div>
                        <a
                            href="/buku/1/pinjam"
                            class="flex h-10 items-center justify-center rounded-full border border-[#6da099] px-6 text-sm font-bold text-[#6da099] transition-colors hover:bg-[#6da099] hover:text-white"
                        >Pinjam</a>
                    </div>
                </div>
            </div>

            {{-- <x-book-card /> --}}
        </div>
    </div>
@endsection
