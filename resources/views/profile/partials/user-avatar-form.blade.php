<style>
    #profile-container {
    width: 150px;
    height: 150px;
    overflow: hidden;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
}
</style>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>
        <!-- Profile image         -->
        <?php
           $avatarPath = "/storage/$user->avatar";
        ?>
        <img class="h-8 w-8 rounded-full" src="{{$avatarPath}}" alt="User Avatar" />
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your profile avatar.") }}
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
            <x-primary-button>{{ __('Upload') }}</x-primary-button>
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
