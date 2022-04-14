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
  <div class="app">
    <component :is="currentView" />
  </div>
</template>
<style>
.app {
  margin-top: 20px;
}
.shade {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgb(0,0,0,0.6);
    height: 100vh;
}
.close-btn {
    padding: 10px;
    cursor: pointer;
}
</style>