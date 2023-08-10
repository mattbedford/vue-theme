<template>
    <nav>
        <div class="nav-main">
			<div class="nav-logos">
                <router-link to="/">
                    <img src='/wp-content/uploads/dagora-ch-icon.webp' class='dag-icon'>
                    <img src='/wp-content/uploads/LOGO-DAGORA-1024x214-1.webp' class='dag-logo'>
                </router-link>
			</div>
			<div class="nav-menu">
                <router-link to="/reports">Reports</router-link>
                <router-link to="/about">About</router-link>
                <router-link to="/cart">Cart</router-link>
				
                <ThemeSwitcher />
			</div>
		</div>
        <router-link to="/cart">
            <div class="nav-cart">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><circle cx="176" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="400" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 80h64l48 272h256"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128"/></svg>
                <span class="cart-counter" v-if="$root.inCart.length > 0">{{ $root.inCart.length }}</span>			
            </div>
        </router-link>
    </nav>
</template>

<script>
import ThemeSwitcher from './ThemeSwitcher.vue';

export default {
    components: { ThemeSwitcher },

};
</script>
