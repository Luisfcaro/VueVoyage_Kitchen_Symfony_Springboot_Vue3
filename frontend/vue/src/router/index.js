import { createRouter, createWebHistory } from "vue-router";
import Categories from "../views/admin/Categories.vue";
import Dashboard from "../views/admin/Dashboard.vue";
import Restaurant from "../views/admin/Restaurant.vue";
import CategoriesRestaurant from "../views/admin/CategoriesRestaurant.vue";


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
  {
    path: "/shop/:filters",
    name: "shop_filter",
    component: () => import('../views/client/Shop.vue')
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
      },
      {
        path: "dashboard/:idRestaurant/categories",
        name: "categoriesRestaurnat",
        component: CategoriesRestaurant
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;