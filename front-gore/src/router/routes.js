const routes = [
  {
    path: "/login",

    component: () => import("layouts/AuthLayout.vue"),
    children: [
      {
        path: "",
        name: "Login",
        component: () => import("src/pages/Auth/login-page.vue"),
      },
    ],
  },

  {
    path: "/",

    component: () => import("src/layouts/admin-layout.vue"),
    meta: { requiresAuth: true },
    children: [
      {
        path: "admin",
        name: "Dash",
        component: () => import("src/pages/index-page.vue"),
      },
      {
        path: "permisos",
        name: "Permisos",
        component: () => import("src/pages/Admin/Permisos/permisos-list.vue"),
      },
      {
        path: "roles",
        name: "Roles",
        component: () => import("src/pages/Admin/Roles/roles-list.vue"),
      },
      {
        path: "usuarios",
        name: "Usuarios",
        component: () => import("src/pages/Admin/Usuarios/usuarios-list.vue"),
      },
      {
        path: "areas",
        name: "Areas",
        component: () => import("src/pages/Admin/Areas/areas-list.vue"),
      },
      {
        path: "cartas",
        name: "Cartas",
        component: () => import("src/pages/Cartas/cartas-list.vue"),
      },
      {
        path: "/renovacion/:id",
        name: "Renovacion",
        component: () => import("src/components/show-renovacion.vue"),
      },
      {
        path: "renovaciones",
        name: "Renovaciones",
        component: () => import("pages/Renovaciones/renovacionesv-list.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("src/pages/error-not-found.vue"),
  },
];

export default routes;
