<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
            {{-- <x-breadcrumb :items="$breadcrumbItems" /> --}}
        </div>
    </div>
    <div id="notifications" style="margin-top: 20px;">
        <!-- Notifikasi akan muncul di sini -->
    </div>
    <script>
        window.Echo.channel('system-announcements')
            .listen('SystemAnnouncement', (e) => {
                let notification = document.createElement('div');
                notification.classList.add('notification');
                notification.innerText = 'Announcement: ' + e.announcement;
                document.getElementById('notifications').appendChild(notification);
            });

        window.Echo.channel('system-alerts')
            .listen('SystemAlert', (e) => {
                let notification = document.createElement('div');
                notification.classList.add('notification');
                notification.innerText = 'Alert: ' + e.alert;
                document.getElementById('notifications').appendChild(notification);
            });
    </script>
</x-dashboard-layout>
