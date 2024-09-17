<!-- resources/js/components/Navbar.vue -->

<template>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">FWS TestApp</a>
            <!-- Toggle button for collapsing the navbar on mobile -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible part of the navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/products" class="nav-link">Products Feed</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/import-products" class="nav-link">Import Products</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navbar',
};
</script>

<style scoped>
/* You can add additional mobile-specific styling here if needed */
</style>
