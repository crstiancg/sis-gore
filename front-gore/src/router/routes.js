const routes = [
  {
    path: "/login",

    component: () => import("layouts/AuthLayout.vue"),
    children: [
      {
        path: "",
        name: "Login",
        component: () => import("pages/Auth/LoginPage.vue"),
      },
    ],
  },

  {
    path: "/",

    component: () => import("layouts/AdminLayout.vue"),
    meta: { requiresAuth: true },
    children: [
      {
        path: "admin",
        name: "Dash",
        component: () => import("pages/IndexPage.vue"),
      },
      {
        path: "permisos",
        name: "Permisos",
        component: () => import("pages/Admin/Permisos/PermisosList.vue"),
      },
      {
        path: "roles",
        name: "Roles",
        component: () => import("pages/Admin/Roles/RolesList.vue"),
      },
      {
        path: "usuarios",
        name: "Usuarios",
        component: () => import("pages/Admin/Usuarios/UsuariosList.vue"),
      },
      {
        path: "areas",
        name: "Areas",
        component: () => import("pages/Admin/Areas/AreasList.vue"),
      },
      {
        path: "cartas",
        name: "Cartas",
        component: () => import("pages/Cartas/cartas-list.vue"),
      },
      {
        path: "oficios",
        name: "Oficios",
        component: () => import("pages/Oficios/oficios-list.vue"),
      },
      {
        path: "multas",
        name: "Multas",
        component: () => import("pages/Multas/multas-list.vue"),
      },
      {
        path: "/renovacion/:id",
        name: "Renovacion",
        component: () => import("src/components/show-renovacion.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
