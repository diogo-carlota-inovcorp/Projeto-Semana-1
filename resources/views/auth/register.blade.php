<x-layouts.layout>
    <form action="/register" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
            <legend class="fieldset-legend">Register</legend>

            <label class="label" for="name">Name</label>
            <input class="input" name="name" placeholder="Your Name" required/>

            <label class="label" for="email">Email</label>
            <input type="email" name="email" class="input" placeholder="Your Email" required/>

            <label class="label">Password</label>
            <input type="password" name="password" class="input" placeholder="Password" required/>

            <label class="label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="input" placeholder="Confirm Password" required/>

            <button class="btn btn-neutral mt-4" >Register</button>
        </fieldset>

    </form>
</x-layouts.layout>
