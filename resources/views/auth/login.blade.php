<x-layouts.layout>
    <form action="/login" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
            <legend class="fieldset-legend">Login</legend>

            <label class="label" for="email">Email</label>
            <input type="Email" name="email" class="input" placeholder="Your Email" required/>
            <x-forms.error name="email" />
            <label class="label">Password</label>
            <input type="password" name="password" class="input" placeholder="Password" required/>
            <x-forms.error name="password" />
            <button class="btn btn-neutral mt-4">Login</button>

        </fieldset>

    </form>
</x-layouts.layout>
