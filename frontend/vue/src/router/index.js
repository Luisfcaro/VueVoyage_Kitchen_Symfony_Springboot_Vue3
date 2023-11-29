import { createRouter, createWebHistory } from "vue-router";

import Categories from "../views/admin/Categories.vue";
import Dashboard from "../views/admin/Dashboard.vue";
import Restaurant from "../views/admin/Restaurant.vue";

const routes = [
  { path: "", redirect: { name: "dash" } },
  {
    path: "/client",
    component: () => import("../views/client/Home.vue"),
    name: "home"
  },
  {
    path: "/admin",
    name: "admin",
    component: () => import("../views/admin/App.vue"),
    children: [
      {
        path: "dashboard",
        name: "dash",
        component: Dashboard,
      },
      {
        path: "dashboard/:idRestaurant",
        name: "dashRest",
        component: Restaurant
      },
      {
        path: "dashboard/categories",
        name: "dashCategories",
        component: Categories
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;