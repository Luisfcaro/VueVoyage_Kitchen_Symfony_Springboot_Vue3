import { createRouter, createWebHistory } from "vue-router";

import Dashboard from "../views/admin/Dashboard.vue";
import Categories from "../views/admin/Categories.vue";
import CanvaPrueva from "../views/CanvaPrueva.vue"

const routes = [
  { path: "", redirect: { name: "dash" } },
  { path: "/admin/dashboard", name: "dash", component: Dashboard },
  { path: "/admin/dashboard/categories", name: "dashCategories", component: Categories },
  { path: "/admin/dashboard/:idRestaurant", name: "dashRest", component: Dashboard },
  { path: "/canva", name: "canva", component: CanvaPrueva }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;