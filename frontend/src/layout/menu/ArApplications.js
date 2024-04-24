const arApplication = [
  {
    heading: "Navigation",
  },
  {
    icon: "bag",
    text: "Authorise Representative",
    link: "#",
    panel: true,
    isAdmin: false,
    newTab: true,
    subPanel: [
      {
        icon: "dashboard-fill",
        text: "Dashboard",
        link: "/dashboard",
      },
      // {
      //   icon: "dashboard-fill",
      //   text: "Application",
      //   link: "/application",
      // },
      {
        icon: "dashboard-fill",
        text: "Activity Log",
        link: "/audit-log",
      },
      {
        icon: "tile-thumb-fill",
        text: "Authorised Representatives",
        active: false,
        subMenu: [
          {
            text: "Update Authorised Representatives",
            link: "/auth-representatives",
          },
          {
            text: "Pending Authorised Representatives",
            link: "/auth-representatives-pending",
          },
          {
            text: "View Authorised Representatives",
            link: "/auth-representatives-view",
          },

        ],
      }
    ]
  }
];

export default arApplication;