@if(Session::has('success'))
<div class="bg-green border border-green-400 text-black px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ Session::get('success') }}</span>
</div>
@endif

@if(Session::has('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ Session::get('error') }}</span>
</div>
@endif