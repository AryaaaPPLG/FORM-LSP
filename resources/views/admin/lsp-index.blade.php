<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Absensi Siswa LSP') }}
            </h2>
            <a href="{{ route('admin.lsp.export-all') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                Download Rekap (DOCX)
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal Sekolah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($forms as $form)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $form->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $form->asal_sekolah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $form->signature }}" class="h-10 border" alt="Signature">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-3">
                                    <a href="{{ route('admin.lsp.export', $form->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Download</a>
                                    
                                    <form action="{{ route('admin.lsp.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $forms->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
