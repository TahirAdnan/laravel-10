<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your profile avatar.") }}
        </p>
    </header>

    <form action="{{ url('/images/upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
        <div>
            <input id="image" name="image" type="file" class="mt-1 block w-full" required/>         
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>
        <p style="margin-top:10px;">
        <div class="flex items-center gap-4">
        <!-- <button type="submit" class="btn btn-primary">Upload</button> -->
            <x-primary-button>{{ __('Upload') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Updated.') }}</p>
            @endif
        </div>
    </form>
</section>
