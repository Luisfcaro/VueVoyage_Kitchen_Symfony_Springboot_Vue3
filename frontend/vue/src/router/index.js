import { createRouter, createWebHistory } from "vue-router";
import Categories from "../views/admin/Categories.vue";
import Dashboard from "../views/admin/Dashboard.vue";
import Restaurant from "../views/admin/Restaurant.vue";
import CategoriesRestaurant from "../views/admin/CategoriesRestaurant.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Home from "../views/client/Home.vue";
import Shop from "../views/client/Shop.vue";
import Users from "../views/admin/Users.vue";
import User from "../views/admin/User.vue";
import Bookings from "../views/admin/Bookings.vue";
import Booking from "../views/admin/Booking.vue";
import TablesOfBooking from "../views/admin/TablesOfBooking.vue";
import RestaurantClient from "../views/client/Restaurant.vue";
import SettingsClient from "../views/client/Settings.vue";
import AuthGuards from "../core/guards/AuthGuard"

const routes = [
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/",
    name: "client",
    component: () => import("../views/client/App.vue"),
    children: [
      {
        path: "home",
        name: "home",
        component: Home
      },
      {
        path: "login",
        name: "login",
        component: Login
      },
      {
        path: "register",
        name: "register",
        component: Register
      },
      {
        path: "shop",
        name: "shop",
        component: Shop
      },
      {
        path: "shop/:filters",
        name: "shop_filter",
        component: Shop
      },
      {
        path: "restaurant/:id",
        name: "restaurant",
        component: RestaurantClient,
      },
      {
        path: 'settings',
        name: 'settings',
        component: SettingsClient,
        beforeEnter: AuthGuards.AuthGuard, meta: { requiresAuth: true }
      }
    ]
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
      },
      {
        path: "dashboard/users",
        name: "dashUsers",
        component: Users,
      },
      {
        path: "dashboard/users/:idUser",
        name: "dashUser",
        component: User,
      },
      {
        path: "dashboard/bookings",
        name: "dashBookings",
        component: Bookings,
      },
      {
        path: "dashboard/bookings/:idBooking",
        name: "dashBooking",
        component: Booking,
      },
      {
        path: "dashboard/bookings/:idBooking/tables",
        name: "TablesOfBooking",
        component: TablesOfBooking,
      }
    ],
    beforeEnter: AuthGuards.authGuardAdmin, meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;