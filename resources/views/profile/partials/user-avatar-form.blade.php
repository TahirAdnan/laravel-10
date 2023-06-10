<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>

        <!-- Profile image -->
        <?php
            if (session('gen_image_url') != null){
                $avatarPath = session('gen_image_url');
            } else {
                $avatarPath = "/storage/$user->avatar";
            }
        ?>
        <img class="h-10 w-10 rounded-full" src="{{$avatarPath}}" alt="User Avatar" />


        <!-- Generate image with AI -->
        <form action="{{ url('openai_new') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Generate avatar from AI.") }}
            </p>
            <x-primary-button>{{ __('Generate Image') }}</x-primary-button>
        </form>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update avatar form computer.") }}
        </p>
    </header>

    <form action="{{ url('avatar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- @method('patch') -->
        <div>
            <input id="image" name="avatar" type="file" class="mt-1 block w-full" required/>         
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>
        <p style="margin-top:10px;">
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Upload Image') }}</x-primary-button>
            @if (session('status') === 'Avatar-uploaded')
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
