<dialog id="DemoAkun" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            onclick="document.getElementById('DemoAkun').close()">✕</button>

        <div role="alert" class="alert mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-neutral h-6 w-6 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm">Gunakan akun demo berikut untuk mengakses dashboard.</span>
        </div>

        <div class="py-4">
            <div class="font-medium">Akun Admin</div>
            <div class="flex flex-col justify-between py-2">
                <label class="block">Email</label>
                <div class="relative">
                    <input id="adminEmail" type="text" value="demoadmin@gmail.com"
                        class="input input-bordered w-full pr-10" readonly>
                    <button type="button"
                        class="btn btn-ghost btn-xs absolute right-2 top-1/2 transform -translate-y-1/2"
                        onclick="copyToClipboard('#adminEmail', this)">
                        <svg id="adminEmailIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <svg id="adminEmailCheckIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col justify-between py-2">
                <label class="block">Password</label>
                <div class="relative">
                    <input id="adminPassword" type="text" value="password" class="input input-bordered w-full pr-10"
                        readonly>
                    <button type="button"
                        class="btn btn-ghost btn-xs absolute right-2 top-1/2 transform -translate-y-1/2"
                        onclick="copyToClipboard('#adminPassword', this)">
                        <svg id="adminPasswordIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <svg id="adminPasswordCheckIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="font-medium">Akun Seller</div>
            <div class="flex flex-col justify-between py-2">
                <label class="block">Email</label>
                <div class="relative">
                    <input id="sellerEmail" type="text" value="demoseller@gmail.com"
                        class="input input-bordered w-full pr-10" readonly>
                    <button type="button"
                        class="btn btn-ghost btn-xs absolute right-2 top-1/2 transform -translate-y-1/2"
                        onclick="copyToClipboard('#sellerEmail', this)">
                        <svg id="sellerEmailIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <svg id="sellerEmailCheckIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex flex-col justify-between py-2">
                <label class="block">Password</label>
                <div class="relative">
                    <input id="sellerPassword" type="text" value="password"
                        class="input input-bordered w-full pr-10" readonly>
                    <button type="button"
                        class="btn btn-ghost btn-xs absolute right-2 top-1/2 transform -translate-y-1/2"
                        onclick="copyToClipboard('#sellerPassword', this)">
                        <svg id="sellerPasswordIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                        <svg id="sellerPasswordCheckIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</dialog>

<script>
    function copyToClipboard(selector, button) {
        const input = document.querySelector(selector);
        if (input) {
            input.select();
            document.execCommand('copy');

            // Toggle icons
            const icon = button.querySelector('svg:not(.hidden)');
            if (icon) {
                icon.classList.add('hidden');
                const checkIcon = button.querySelector(`#${icon.id}CheckIcon`);
                if (checkIcon) {
                    checkIcon.classList.remove('hidden');
                }
            }

            // Reset icons after 3 seconds
            setTimeout(() => {
                const icon = button.querySelector('svg.hidden');
                if (icon) {
                    icon.classList.remove('hidden');
                    const checkIcon = button.querySelector(`#${icon.id.replace('Check', '')}CheckIcon`);
                    if (checkIcon) {
                        checkIcon.classList.add('hidden');
                    }
                }
            }, 3000);
        }
    }
</script>
