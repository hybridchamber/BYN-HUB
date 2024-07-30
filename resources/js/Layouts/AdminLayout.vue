<template>
    <div class="flex h-screen bg-gray-200">
    <!-- Sidebar -->
    <div class="w-60 bg-blue-900 text-white flex flex-col shadow-current">
        <!-- Logo -->
        <div class="p-4 text-lg font-bold flex items-center">
          <img src="http://ts1.mm.bing.net/th?id=OIP.6j8ArTjKPxeZ4RDqh6SZEAHaGs&pid=15.1" alt="Logo" class="h-8 w-auto mr-2 rounded-full">
          <span>BYN-HUB</span>
        </div>
        <!-- Navigation Links -->
        <nav class="mt-2 flex-1 overflow-y-auto">
          <ul>
            <li>
              <SidebarLink href="/admins" :active="isActive('/admins')" :class="{'bg-blue-500':isActive('/admins'),'text-white':true}">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h6.75m6.75 0H20.25M3.75 16.5h6.75m6.75 0H20.25M3.75 12h6.75m6.75 0H20.25M3.75 3.75A1.5 1.5 0 015.25 2.25h3.75a1.5 1.5 0 011.5 1.5v3.75a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V5.25m12 1.5a1.5 1.5 0 011.5-1.5h3.75a1.5 1.5 0 011.5 1.5v3.75a1.5 1.5 0 01-1.5 1.5h-3.75a1.5 1.5 0 01-1.5-1.5V5.25m-12 12a1.5 1.5 0 011.5-1.5h3.75a1.5 1.5 0 011.5 1.5v3.75a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-3.75m12 1.5a1.5 1.5 0 011.5-1.5h3.75a1.5 1.5 0 011.5 1.5v3.75a1.5 1.5 0 01-1.5 1.5h-3.75a1.5 1.5 0 01-1.5-1.5v-3.75" />
                     </svg>
                </template>
                <span class="text-white">Dashboard</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink href= "/users" :active="isActive('/users') " :class="{'bg-blue-500':isActive('/users'),'text-white':true}" v-if="hasRole('admin')">
                <template #icon>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                  </svg>
                </template>
                <span>Users</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink href="/roles" :active="isActive('/roles')" :class="{'bg-blue-500':isActive('/roles'),'text-white':true}" v-if="hasRole('admin')">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                    </svg>
                </template>
                <span>Roles</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink href="/permissions" :active="isActive('/permissions')" :class="{'bg-blue-500':isActive('/permissions'),'text-white':true}"v-if="hasRole('admin')">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                    </svg>
                </template>
                <span>Permissions</span>
              </SidebarLink>
            </li>
            <li>
              <SidebarLink href="/posts" :active="isActive('/posts')" :class="{'bg-blue-500':isActive('/posts'),'text-white':true}">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                </template>
                <span>Posting</span>
              </SidebarLink>
              <SidebarLink href="/bulletinboards" :active="isActive('/bulletinboards')" :class="{'bg-blue-500':isActive('/bulletinboards'),'text-white':true}">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </template>
                <span>Bulletin Board</span>
              </SidebarLink>
              <SidebarLink href="/youthprofiles" :active="isActive('/youthprofiles')" :class="{'bg-blue-500':isActive('/youthprofiles'),'text-white':true}">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </template>
                <span>Demographic Profile</span>
              </SidebarLink>
            </li>
          </ul>
        </nav>

        <!-- Optional: Footer or additional content -->
      </div>


      <!-- Main content -->
      <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Navbar inside main content -->
      <div class="flex items-center justify-between p-3 bg-blue-900 text-white w-full shadow-current">
        <div class="text-lg font-bold">Dashboard</div>
        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="md:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
        <div class="hidden md:flex space-x-4">
          <div class="flex-grow px-4">
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M14.293 13.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 111.414-1.414l3 3zM10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
                </svg>
              </span>
              <input type="text" class="block w-auto pl-10 pr-20 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-gray-500 focus:border-gray-500 sm:text-sm" placeholder="Search">
            </div>
          </div>
          <div class="ms-3 relative">
            <!-- Ensure authUser is defined before accessing its properties -->
            <template v-if="authUser">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                      Welcome {{ authUser.name }}
                      <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                      </svg>
                    </button>
                  </span>
                </template>
                <template #content>
                  <!-- Example routes provided; replace with actual route definitions -->
                  <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                </template>
              </Dropdown>
            </template>
          </div>
        </div>
      </div>

      <div class="flex-1 overflow-y-auto bg-white border-separate h-full shadow-inner" style="background-image: url('/image/Design (7).png'); background-size: cover; background-position: center; ">
        <slot></slot>
      </div>
    </div>

    </div>
  </template>

  <script setup>
    import { ref } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import SidebarLink from "@/Components/SidebarLink.vue";
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import { usePermission } from "@/composables/permissions";
    

    const { hasRole } = usePermission();
    const showingNavigationDropdown = ref(false);
    const page = usePage();
    const authUser = page.props.auth.user;

    // Function to determine if link is active
    const isActive = (route) => {
      return window.location.pathname === route;
    };
  </script>

  <style scoped>
  /* Add your custom styles here */
  </style>
