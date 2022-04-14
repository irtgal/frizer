<script>
import AdminIndex from './components/Admin/Index.vue';

const routes = {
  // admin
  '/admin/': AdminIndex,
}

export default {
  data() {
	return {
    currentPath: window.location.hash
	}
  },
  computed: {
	currentView() {
    return routes[this.currentPath.slice(1) || '/'] 
	}
  },
  mounted() {
	window.addEventListener('hashchange', () => {
      this.currentPath = window.location.hash
		})
  }
}
</script>

<template>
  <a href="#/">Home</a> |
  <a href="#/about">About</a> |
  <a href="#/non-existent-path">Broken Link</a>
  <component :is="currentView" />
</template>