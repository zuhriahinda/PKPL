<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <title>Particles JS Section</title>

    <style>
      :root {
        --navbar-bg-color: rgba(0, 0, 0, 0);

        --navbar-text-color: hsl(0, 0%, 98%);
        --navbar-text-color-focus: white;
        --navbar-bg-contrast: hsla(242, 98%, 48%, 0.612);
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        font-family: Arial, Helvetica, sans-serif;
        line-height: 1.6;
        background: url("image/Background1.jpg") no-repeat center center fixed;
        background-size: cover;
        position: relative; /* Add this to position the overlay correctly */
        overflow: hidden; /* Ensure overlay does not cause scrollbars */
      }

      body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Dark overlay */
        z-index: 0; /* Ensure the overlay is behind the content */
      }
      h1,
      p {
        color: #ffffff; /* Putih */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Bayangan teks */
      }

      main,
      footer {
        position: relative; /* Ensure these are above the overlay */
        z-index: 1; /* Ensure these are above the overlay */
      }

      main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .container {
        max-width: 1000px;
        padding-left: 1.4rem;
        padding-right: 1.4rem;
        margin-left: auto;
        margin-right: auto;
        text-align: center; /* Rata tengah untuk teks di dalamnya */
      }

      #navbar {
        --navbar-height: 100px;
        position: fixed;
        height: var(--navbar-height);
        background-color: var(--navbar-bg-color);
        left: 0;
        right: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        z-index: 1000; /* Ensure navbar stays on top */
      }

      .navbar-container {
        display: flex;
        justify-content: space-between;
        height: 100%;
        align-items: center;
      }

      .home-link,
      .navbar-link {
        color: var(--navbar-text-color);
        transition: color 0.2s ease-in-out;
        text-decoration: none;
        display: flex;
        font-weight: 400;
        align-items: center;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
      }

      .home-link:focus,
      .home-link:hover {
        color: var(--navbar-text-color-focus);
      }

      .navbar-link {
        justify-content: center;
        width: 100%;
        padding: 0.4em 0.8em;
        border-radius: 5px;
      }

      .navbar-link:focus,
      .navbar-link:hover {
        color: var(--navbar-text-color-focus);
        background-color: var(--navbar-bg-contrast);
      }

      .navbar-logo {
        background-color: none;
        width: 50px;
        height: 50px;
        margin-right: 0.5em;
      }

      .navbar-toggle {
        cursor: pointer;
        border: none;
        background-color: transparent;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
      }

      .icon-bar {
        display: block;
        width: 25px;
        height: 4px;
        margin: 2px;
        transition: background-color 0.2s ease-in-out,
          transform 0.2s ease-in-out, opacity 0.2s ease-in-out;
        background-color: var(--navbar-text-color);
      }

      .navbar-toggle:focus .icon-bar,
      .navbar-toggle:hover .icon-bar {
        background-color: var(--navbar-text-color-focus);
      }

      #navbar.opened .navbar-toggle .icon-bar:first-child,
      #navbar.opened .navbar-toggle .icon-bar:last-child {
        position: absolute;
        margin: 0;
        width: 30px;
      }

      #navbar.opened .navbar-toggle .icon-bar:first-child {
        transform: rotate(45deg);
      }

      #navbar.opened .navbar-toggle .icon-bar:nth-child(2) {
        opacity: 0;
      }

      #navbar.opened .navbar-toggle .icon-bar:last-child {
        transform: rotate(-45deg);
      }

      #navbar-menu {
        position: fixed;
        top: var(--navbar-height);
        bottom: 0;
        transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out,
          left 0.2s ease-in-out, right 0.2s ease-in-out;
        opacity: 0;
        visibility: hidden;
      }

      #navbar-menu.sidebar,
      #navbar-menu.sidebar.left {
        left: -1000px;
        right: 0;
      }

      #navbar-menu.sidebar.right {
        right: -1000px;
        left: 0;
      }

      #navbar-menu.detached,
      #navbar-menu.attached {
        left: 0;
        right: 0;
      }

      #navbar.opened #navbar-menu {
        background-color: rgba(0, 0, 0, 0.4);
        opacity: 1;
        visibility: visible;
      }

      #navbar.opened #navbar-menu.sidebar.left {
        left: 0;
      }

      #navbar.opened #navbar-menu.sidebar.right {
        right: 0;
      }

      .navbar-links {
        list-style-type: none;
        max-height: 0;
        overflow: hidden;
        position: absolute;
        background-color: var(--navbar-bg-color);
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      #navbar.opened .navbar-links {
        padding: 1em;
        max-height: none;
      }

      .sidebar .navbar-links {
        top: 0;
        bottom: 0;
      }

      .left.sidebar .navbar-links {
        left: 0;
        right: unset;
        box-shadow: 5px 20px 20px rgba(0, 0, 0, 0.3);
      }

      .right.sidebar .navbar-links {
        right: 0;
        left: unset;
        box-shadow: -5px 20px 20px rgba(0, 0, 0, 0.3);
      }

      .detached .navbar-links {
        left: 0;
        right: 0;
        margin: 1.4rem;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      }

      .attached .navbar-links {
        left: 0;
        right: 0;
        box-shadow: 0 20px 20px rgba(0, 0, 0, 0.3);
      }

      .navbar-item {
        margin: 0.4em;
        width: 100%;
      }

      @media screen and (min-width: 700px) {
        .navbar-toggle {
          display: none;
        }

        #navbar #navbar-menu,
        #navbar.opened #navbar-menu {
          visibility: visible;
          opacity: 1;
          position: static;
          display: block;
          height: 100%;
        }

        #navbar .navbar-links,
        #navbar.opened .navbar-links {
          margin: 0;
          padding: 0;
          box-shadow: none;
          position: static;
          flex-direction: row;
          list-style-type: none;
          max-height: max-content;
          width: 100%;
          height: 100%;
        }

        #navbar .navbar-link:last-child {
          margin-right: 0;
        }
      }

      #options {
        display: flex;
        flex-direction: column;
      }

      /* Footer Styling */
      footer {
        background-color: rgba(0, 0, 0, 0.563); /* Semi-transparent black */
        color: #fff;
        text-align: center;
        padding: 1rem 0;
      }

      footer p {
        margin: 0;
      }

      footer a {
        color: #fff;
        text-decoration: underline;
      }

      footer a:hover {
        color: #ccc;
      }
      footer div a {
        color: #fff;
        margin: 0 10px;
        font-size: 24px;
        text-decoration: none;
      }

      footer div a:hover {
        color: #ccc;
      }
      /* Styling untuk kontainer footer */
    .footer-content {
        display: flex;
        justify-content: center; /* Pusatkan teks dan logo */
        align-items: center; /* Vertikal sejajarkan teks dan logo */
        background-color: rgba(0, 0, 0, 0); /* Semi-transparan */
        padding: 1rem;
        color: #fff;
    }

    /* Styling logo di footer */
    .footer-logo {
        height: 80px; /* Sesuaikan tinggi logo */
        width: auto;
        margin: 20px 100px; /* Jarak antara logo dan teks */
    }

    /* Teks footer */
    .footer-text {
        text-align: center;
    }

    .footer-text p {
        margin: 0;
    }

    .footer-text a {
        color: #fff;
        text-decoration: underline;
    }

    .footer-text a:hover {
        color: #ccc;
    }

    /* Styling untuk ikon sosial di footer */
    .social-links {
        display: flex;
        justify-content: center;
        margin-top: 10px; /* Jarak antara ikon dan teks di atasnya */
    }

    .social-links a {
        color: #fff;
        margin: 0 10px; /* Jarak antar ikon */
        font-size: 24px; /* Ukuran ikon */
        text-decoration: none;
    }

    .social-links a:hover {
        color: #ccc; /* Warna ikon saat hover */
    }

    .footer-text a {
        font-size: inherit; 
    }
    </style>
  </head>

  <body>
    <header id="navbar">
      <nav class="navbar-container container">
        <a href="/" class="home-link">
            <div class="navbar-logo">
                <img src="image/logo2.jpg" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%;">
            </div>
          SmartCity Progress
        </a>
        <button
          type="button"
          class="navbar-toggle"
          aria-label="Toggle menu"
          aria-expanded="false"
          aria-controls="navbar-menu"
        >
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div id="navbar-menu" class="detached">
          <ul class="navbar-links">
            <li class="navbar-item">
              <a
                class="navbar-link"
                href="{{ route('filament.admin.auth.login') }}"
                >Login</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main>
      <div class="container">
        <h1>Welcome to SmartCity Progress</h1>
        <p>situs resmi Dinas Komunikasi dan Informatika Kota mataram</p>
      </div>
    </main>

    <footer>
        <div class="footer-content">
          <!-- Logo Diskominfo di kiri -->
          
            <img
              src="image/logo.png"
              alt="Diskominfo Logo"
              class="footer-logo"
            />
          
  
          <!-- Informasi di tengah -->
          <div class="footer-text">
            <p>&copy; 2024 SmartCity. All rights reserved.</p>
            <p>
              Contact us:
              <a href="mailto:info@smartcity.com">info@smartcity.com</a>
            </p>
            <div class="social-links">
              <a href="https://www.instagram.com/yourprofile" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="https://www.youtube.com/yourchannel" target="_blank">
                <i class="fab fa-youtube"></i>
              </a>
              <a href="https://wa.me/yourwhatsappnumber" target="_blank">
                <i class="fab fa-whatsapp"></i>
              </a>
            </div>
          </div>
  
          <!-- Logo UMM di kanan -->
          
            <img src="image/logo-umm.png" alt="UMM Logo" class="footer-logo" />
          </div>
        </div>
      </footer>

    <!-- particles.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- particles.js config -->
    <script>
      const navbar = document.getElementById("navbar");
      const navbarToggle = navbar.querySelector(".navbar-toggle");

      function openMobileNavbar() {
        navbar.classList.add("opened");
        navbarToggle.setAttribute("aria-expanded", "true");
      }

      function closeMobileNavbar() {
        navbar.classList.remove("opened");
        navbarToggle.setAttribute("aria-expanded", "false");
      }

      navbarToggle.addEventListener("click", () => {
        if (navbar.classList.contains("opened")) {
          closeMobileNavbar();
        } else {
          openMobileNavbar();
        }
      });

      const navbarMenu = navbar.querySelector("#navbar-menu");
      const navbarLinksContainer = navbar.querySelector(".navbar-links");

      navbarLinksContainer.addEventListener("click", (clickEvent) => {
        clickEvent.stopPropagation();
      });

      navbarMenu.addEventListener("click", closeMobileNavbar);

      document
        .getElementById("options")
        .querySelectorAll("input[name='navtype']")
        .forEach((option) => {
          option.addEventListener("change", (e) => {
            const navType = e.target.id.split("-").join(" ");
            navbarMenu.classList = navType;
          });
        });

      // particles.js configuration
      particlesJS("particles-js", {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              value_area: 800,
            },
          },
          color: {
            value: "#ffffff",
          },
          shape: {
            type: "circle",
            stroke: {
              width: 0,
              color: "#000000",
            },
            polygon: {
              nb_sides: 5,
            },
          },
          opacity: {
            value: 0.5,
            random: false,
            anim: {
              enable: false,
              speed: 1,
              opacity_min: 0.1,
              sync: false,
            },
          },
          size: {
            value: 3,
            random: true,
            anim: {
              enable: false,
              speed: 40,
              size_min: 0.1,
              sync: false,
            },
          },
          line_linked: {
            enable: true,
            distance: 150,
            color: "#ffffff",
            opacity: 0.4,
            width: 1,
          },
          move: {
            enable: true,
            speed: 6,
            direction: "none",
            random: false,
            straight: false,
            out_mode: "out",
            bounce: false,
            attract: {
              enable: false,
              rotateX: 600,
              rotateY: 1200,
            },
          },
        },
        interactivity: {
          detect_on: "canvas",
          events: {
            onhover: {
              enable: true,
              mode: "repulse",
            },
            onclick: {
              enable: true,
              mode: "push",
            },
            resize: true,
          },
          modes: {
            grab: {
              distance: 400,
              line_linked: {
                opacity: 1,
              },
            },
            bubble: {
              distance: 400,
              size: 40,
              duration: 2,
              opacity: 8,
              speed: 3,
            },
            repulse: {
              distance: 200,
              duration: 0.4,
            },
            push: {
              particles_nb: 4,
            },
            remove: {
              particles_nb: 2,
            },
          },
        },
        retina_detect: true,
      });
    </script>
  </body>
</html>