<div class="my-4 max-w-screen-2xl">
  <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
    <div class="flex flex-col space-y-3 p-4 lg:flex-row lg:items-center lg:justify-between lg:space-x-4 lg:space-y-0">
      <div class="w-full md:w-1/2">
        <div class="flex items-center">
          <label for="simple-search" class="sr-only">Search</label>
          <div class="relative w-full">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
              <svg aria-hidden="true" class="size-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input type="text" id="simple-search" wire:model.live.debounce.300ms="keyword" type="search"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
              placeholder="Search">
          </div>
        </div>
      </div>
      <div class="flex flex-shrink-0 flex-col space-y-3 md:flex-row md:items-center md:space-x-3 md:space-y-0">
        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" data-dropdown-placement="bottom-end"
          class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:w-auto"
          type="button">
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="size-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
          </svg>
          <span>Filter</span>
          <svg class="size-4 -mr-1 ml-1.5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
          </svg>
        </button>
        <form id="filterDropdown" class="z-10 hidden w-48 rounded-lg bg-white p-3 shadow dark:bg-gray-700">
          <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
            @foreach ($roles as $role)
              <li wire:key="{{ $role->id }}" class="flex items-center">
                <input id="{{ $role->name }}" type="radio" {{ Request::get('role') === $role->name ? 'checked' : '' }} name="role" onchange="this.form.submit()" value="{{ $role->name }}"
                  class="size-4 rounded-full border-gray-300 bg-gray-100 text-primary-600 focus:ring-0 focus:ring-primary-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-primary-600">
                <label for="{{ $role->name }}" class="ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-100">{{ Str::ucfirst($role->name) }} ({{ $role->users->count() }})</label>
              </li>
            @endforeach
          </ul>
        </form>
      </div>
    </div>
    <div class="overflow-x-auto">
      <div wire:loading.flex wire:target="keyword" class="flex items-center justify-center gap-4 px-4 py-20">
        <div role="status">
          <svg aria-hidden="true" class="size-12 inline animate-spin fill-purple-600 text-gray-200 dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="currentColor" />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentFill" />
          </svg>
          <span class="sr-only">Loading...</span>
        </div>
        <p class="-mt-1.5 text-4xl/none font-semibold text-white">sabar ye</p>
      </div>
      @if ($members->isEmpty())
        <div wire:loading.remove wire:target="keyword" class="flex items-center justify-center gap-4 px-4 py-20">
          <p class="-mt-1.5 text-4xl/none font-semibold text-white">Tidak Ada User</p>
        </div>
      @else
        <table wire:loading.remove wire:target="keyword" class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
          <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th class="px-5 py-3">Role</th>
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">Username</th>
              <th class="px-4 py-3">No. HP</th>
              <th class="px-4 py-3">Tanggal Bergabung</th>
              <th class="px-4 py-3">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($members as $member)
              <tr wire:key="{{ $member->id }}" class="border-b hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                <td class="px-4 py-2">
                  @if ($member->role->name == 'karyawan')
                    <span class="me-2 rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">{{ Str::ucfirst($member->role->name) }}</span>
                  @else
                    <span class="me-2 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">{{ Str::ucfirst($member->role->name) }}</span>
                  @endif
                </td>
                <th scope="row" class="whitespace-nowrap px-4 py-3 font-medium text-gray-900 dark:text-white">
                  {{ $member->name }}
                </th>
                <td class="px-4 py-3">
                  {{ $member->username }}
                </td>
                <td class="px-4 py-3">{{ $member->phone_number }}</td>
                <td class="px-4 py-3">{{ $member->created_at->translatedFormat('j F Y') }}</td>
                <td class="flex items-center justify-end px-4 py-3">
                  <button type="button" x-on:click="$dispatch('prepare restore user', { id: '{{ $member->id }}' })"
                    class="me-2 inline-flex items-center rounded-full bg-blue-700 p-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="size-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd"
                        d="M3 6a3 3 0 1 1 4 2.83v6.34a3.001 3.001 0 1 1-2 0V8.83A3.001 3.001 0 0 1 3 6Zm11.207-2.707a1 1 0 0 1 0 1.414L13.914 5H15a4 4 0 0 1 4 4v6.17a3.001 3.001 0 1 1-2 0V9a2 2 0 0 0-2-2h-1.086l.293.293a1 1 0 0 1-1.414 1.414l-2-2a1 1 0 0 1 0-1.414l2-2a1 1 0 0 1 1.414 0Z"
                        clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Restore</span>
                  </button>
                  <button x-on:click="$dispatch('prepare destroy user', { id: '{{ $member->id }}' })" type="button"
                    class="me-2 inline-flex items-center rounded-full bg-red-700 p-2.5 text-center text-sm font-medium text-white hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg class="size-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd"
                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                        clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Delete</span>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>