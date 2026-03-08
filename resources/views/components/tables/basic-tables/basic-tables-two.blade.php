@props(['contacts'])

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-white/[0.05] dark:bg-white/[0.03]">

    <!-- Header -->
    <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Recent Contacts
        </h3>

        <div class="flex items-center gap-3">
            <button
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                See all
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="max-w-full overflow-x-auto">
        <table class="w-full">
            <thead
                class="border-t border-gray-100 bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($contacts as $row)
                    <tr class="border-b border-gray-100 dark:border-white/[0.05]">

                        <!-- ID -->
                        <td class="px-6 py-3.5 text-sm text-gray-700 dark:text-gray-400">
                            {{ $row->id }}
                        </td>

                        <!-- Customer -->
                        <td class="px-6 py-3.5">
                            <div>
                                <div class="font-medium text-gray-700 dark:text-gray-400">
                                    {{ $row->first_name }} {{ $row->last_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $row->phone }}
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td class="px-6 py-3.5 text-sm text-gray-700 dark:text-gray-400">
                            {{ $row->email }}
                        </td>

                        <!-- Message -->
                        <td class="px-6 py-3.5 text-sm text-gray-700 dark:text-gray-400">
                            {{ Str::limit($row->message, 50) }}
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-3.5 text-sm text-gray-700 dark:text-gray-400">
                            {{ $row->created_at->format('d M Y') }}
                        </td>

                        <!-- Action -->
                        <td class="px-6 py-3.5">
                            <form action="{{ route('contact.destroy', $row->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    <svg class="size-5 text-gray-700 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                            a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                            m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                            
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                            Tidak ada data kontak
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
