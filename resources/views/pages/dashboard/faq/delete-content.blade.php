<section class="space-y-6">
    <!-- Tombol Delete -->
    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-faq')">
        {{ __('Delete FAQ') }}
    </x-danger-button>

    <!-- Modal -->
    <x-modal name="confirm-delete-faq" focusable class="fixed inset-0 z-[9999]">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-6">
            <form method="post" action="{{ route('faq.destroy', $faq) }}"
                  class="bg-white dark:bg-gray-900 rounded-lg shadow-xl w-full max-w-md p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this FAQ?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Once deleted, this FAQ will be permanently removed.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button type="submit" class="ml-3">
                        {{ __('Delete FAQ') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
