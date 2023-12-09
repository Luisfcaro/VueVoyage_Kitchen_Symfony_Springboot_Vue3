import { createRouter, createWebHistory } from "vue-router";


const routes = [
  {
    path: "/",
    redirect: { name: "home" }
  },
  {
    path: "/home",
    name: "home",
    component: () => import('../views/client/Home.vue')
  },
  {
    path: "/shop",
    name: "shop",
    component: () => import('../views/client/Shop.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;