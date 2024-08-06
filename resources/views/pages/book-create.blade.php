@extends('index')

@section('page')
    <form
        class="flex flex-col gap-6 p-6"
        type="multipart/form-data"
        action="/buku"
        method="POST"
    >
        @csrf

        <div class="flex flex-col gap-12 overflow-hidden rounded-3xl bg-white p-10">
            <h1>Tambah Buku</h1>

            <div class="flex flex-col gap-2">
                <div class="relative h-[246px] w-[190px] overflow-hidden rounded-3xl bg-gray-300">
                </div>

                <input
                    value="{{ old('image') }}"
                    class="text-xs"
                    type="file"
                    name="image"
                    accept="image/*"
                >
                @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-6">
                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Nama Buku</p>
                    <input
                        value="{{ old('title') }}"
                        type="text"
                        placeholder="Nama Buku"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="title"
                    >
                    @error('title')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">ISBN</p>
                    <input
                        value="{{ old('isbn') }}"
                        type="text"
                        placeholder="ISBN"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="isbn"
                    >
                    @error('isbn')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Penulis</p>
                    <input
                        value="{{ old('author') }}"
                        type="text"
                        placeholder="Penulis"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="author"
                    >
                    @error('author')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Penerbit</p>
                    <input
                        value="{{ old('publisher') }}"
                        type="text"
                        placeholder="Penerbit"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="publisher"
                    >
                    @error('publisher')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Tanggal Terbit</p>
                    <input
                        value="{{ old('publication_date') }}"
                        type="date"
                        placeholder="Tanggal Terbit"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="publication_date"
                    >
                    @error('publication_date')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Stok</p>
                    <input
                        value="{{ old('stock') }}"
                        min="0"
                        step="1"
                        type="number"
                        placeholder="Stok"
                        class="h-10 w-full rounded-full border border-gray-200 px-4 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="stock"
                    >
                    @error('stock')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>

                <label class="flex flex-col gap-2">
                    <p class="text-sm font-medium">Deskripsi</p>
                    <textarea
                        value="{{ old('description') }}"
                        type="text"
                        placeholder="Deskripsi Buku"
                        class="min-h-40 w-full rounded-3xl border border-gray-200 px-4 py-2 text-sm font-bold outline-none focus:border-[#6da099] focus:shadow-md"
                        name="description"
                    ></textarea>
                    @error('description')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </label>
            </div>
        </div>

        <button
            type="submit"
            class="h-10 w-full rounded-full bg-[#6da099] text-sm font-bold text-white"
        >Simpan</button>
    </form>
@endsection
