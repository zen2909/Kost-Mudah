<div class="bg-white rounded-xl border shadow-sm p-6">

    <form method="GET" action="{{ route('tenant.kost.index') }}">

        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-4">

            {{-- Search --}}
            <div>
                <label class="text-xs font-semibold uppercase">
                    Cari Kost
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama kost, alamat..."
                    class="w-full mt-2 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700">
            </div>

            {{-- Kelurahan --}}
            <div>
                <label class="text-xs font-semibold uppercase">
                    Kelurahan
                </label>

                <select
                    name="kelurahan"
                    class="w-full mt-2 border rounded-lg px-4 py-3">

                    <option value="">Semua Kelurahan</option>

                    @foreach($kelurahans as $kelurahan)
                        <option
                            value="{{ $kelurahan }}"
                            {{ request('kelurahan') == $kelurahan ? 'selected' : '' }}>
                            {{ $kelurahan }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Tipe Kost --}}
            <div>
                <label class="text-xs font-semibold uppercase">
                    Tipe Kost
                </label>

                <select
                    name="type"
                    class="w-full mt-2 border rounded-lg px-4 py-3">

                    <option value="">Semua</option>

                    <option
                        value="Putra"
                        {{ request('type') == 'Putra' ? 'selected' : '' }}>
                        Putra
                    </option>

                    <option
                        value="Putri"
                        {{ request('type') == 'Putri' ? 'selected' : '' }}>
                        Putri
                    </option>

                    <option
                        value="Campur"
                        {{ request('type') == 'Campur' ? 'selected' : '' }}>
                        Campur
                    </option>

                </select>
            </div>

            {{-- Harga --}}
            <div>
                <label class="text-xs font-semibold uppercase">
                    Harga
                </label>

                <select
                    name="price"
                    class="w-full mt-2 border rounded-lg px-4 py-3">

                    <option value="">Semua Harga</option>

                    <option
                        value="1"
                        {{ request('price') == '1' ? 'selected' : '' }}>
                        ≤ Rp1.000.000
                    </option>

                    <option
                        value="2"
                        {{ request('price') == '2' ? 'selected' : '' }}>
                        Rp1.000.000 - Rp2.000.000
                    </option>

                    <option
                        value="3"
                        {{ request('price') == '3' ? 'selected' : '' }}>
                        Rp2.000.000 - Rp3.000.000
                    </option>

                    <option
                        value="4"
                        {{ request('price') == '4' ? 'selected' : '' }}>
                        > Rp3.000.000
                    </option>

                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="w-full bg-cyan-900 hover:bg-cyan-800 text-white py-3 rounded-lg font-semibold">

                    Cari

                </button>

                <a
                    href="{{ route('tenant.kost.index') }}"
                    class="w-full border text-center py-3 rounded-lg hover:bg-gray-100">

                    Reset

                </a>

            </div>

        </div>

    </form>

</div>