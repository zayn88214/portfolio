/**
 * Main Script for Zainfolio
 * Organized into individual modules for better maintainability and decoupled from backend elements.
 */

document.addEventListener("DOMContentLoaded", () => {
  initFAQ();
  initCookies();
  initTheme();
  initNavigation();
  initScrollObservers();
  initTabs();
  initPortfolio();
  initContactForm();
});

// --- FAQ Accordion ---
function initFAQ() {
  const faqButtons = document.querySelectorAll(".faq-item");
  faqButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const panel = button.nextElementSibling;
      const isOpen = panel.classList.contains("open");

      faqButtons.forEach((item) => {
        item.setAttribute("aria-expanded", "false");
        const sibling = item.nextElementSibling;
        if (sibling) sibling.classList.remove("open");
        const icon = item.querySelector(".icon");
        if (icon) icon.textContent = "+";
      });

      if (!isOpen) {
        panel.classList.add("open");
        button.setAttribute("aria-expanded", "true");
        const icon = button.querySelector(".icon");
        if (icon) icon.textContent = "-";
      }
    });
  });
}

// --- Cookie Banner ---
function initCookies() {
  const cookieBanner = document.querySelector(".cookie");
  const cookieSettings = document.querySelector(".cookie-settings");
  const acceptButton = document.querySelector("#acceptCookies");
  const rejectButton = document.querySelector("#rejectCookies");
  const customizeButton = document.querySelector("#customizeCookies");

  const cookieChoice = localStorage.getItem("cookieChoice");
  if (cookieChoice && cookieBanner) {
    cookieBanner.style.display = "none";
  }

  [acceptButton, rejectButton, customizeButton].forEach((btn) => {
    if (!btn) return;
    btn.addEventListener("click", () => {
      localStorage.setItem("cookieChoice", "set");
      if (cookieBanner) cookieBanner.style.display = "none";
    });
  });

  if (cookieSettings && cookieBanner) {
    cookieSettings.addEventListener("click", () => {
      cookieBanner.style.display = "block";
    });
  }
}

// --- Theme Toggle ---
function initTheme() {
  const themeToggle = document.querySelector(".theme-toggle");
  const savedTheme = localStorage.getItem("theme");

  if (savedTheme === "light") {
    document.body.classList.add("theme-light");
  }

  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      document.body.classList.toggle("theme-light");
      localStorage.setItem(
        "theme",
        document.body.classList.contains("theme-light") ? "light" : "dark"
      );
    });
  }
}

// --- Navigation ---
function initNavigation() {
  const navToggle = document.querySelector(".nav-toggle");
  const siteHeader = document.querySelector(".site-header");
  const mobileNavLinks = document.querySelectorAll(".mobile-nav a");

  const closeMobileNav = () => {
    if (!siteHeader || !navToggle) return;
    siteHeader.classList.remove("is-menu-open");
    navToggle.setAttribute("aria-expanded", "false");
  };

  if (navToggle && siteHeader) {
    navToggle.addEventListener("click", () => {
      const isOpen = siteHeader.classList.toggle("is-menu-open");
      navToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
  }

  mobileNavLinks.forEach((link) => {
    link.addEventListener("click", closeMobileNav);
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 920) {
      closeMobileNav();
    }
  });
}

// --- Scroll Observers (Reveal & Stats Count) ---
function initScrollObservers() {
  const revealItems = document.querySelectorAll(".reveal, .reveal-stagger");
  const statItems = document.querySelectorAll(".stat");

  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );

  revealItems.forEach((item) => revealObserver.observe(item));

  const countObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const stat = entry.target;
        const target = Number(stat.getAttribute("data-target")) || 0;
        const count = stat.querySelector(".count");
        let current = 0;
        const step = Math.max(1, Math.ceil(target / 40));

        const interval = setInterval(() => {
          current += step;
          if (current >= target) {
            current = target;
            clearInterval(interval);
          }
          if (count) {
            count.textContent = String(current);
          }
        }, 30);

        countObserver.unobserve(stat);
      });
    },
    { threshold: 0.5 }
  );

  statItems.forEach((stat) => countObserver.observe(stat));
}

// --- Tabs ---
function initTabs() {
  const tabButtons = document.querySelectorAll(".tab");
  tabButtons.forEach((tab) => {
    tab.addEventListener("click", () => {
      const target = tab.getAttribute("data-tab");

      tabButtons.forEach((btn) => btn.classList.remove("active"));
      document.querySelectorAll(".tab-panel").forEach((panel) => {
        panel.classList.remove("active");
      });

      tab.classList.add("active");
      const panel = document.querySelector(`.tab-panel[data-tab="${target}"]`);
      if (panel) panel.classList.add("active");
    });
  });
}

// --- Portfolio (Search, Filter, Modal) ---
function initPortfolio() {
  const searchInput = document.querySelector(".search-input");
  const projectCards = document.querySelectorAll(".project-card");
  const filterButtons = document.querySelectorAll(".filter-btn");
  const portfolioItems = document.querySelectorAll(".portfolio-item");
  const portfolioModal = document.querySelector("#portfolioModal");
  const modalClose = document.querySelector(".modal-close");
  const modalTitle = document.querySelector(".modal-title");
  const modalImage = document.querySelector(".modal-image");
  const modalDesc = document.querySelector(".modal-desc");
  const modalLink = document.querySelector(".modal-link");

  const portfolioObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("reveal");
          portfolioObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  portfolioItems.forEach((item) => portfolioObserver.observe(item));

  if (searchInput) {
    searchInput.addEventListener("input", (event) => {
      const query = event.target.value.toLowerCase();
      projectCards.forEach((card) => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(query) ? "grid" : "none";
      });
    });
  }

  if (filterButtons.length && portfolioItems.length) {
    filterButtons.forEach((button) => {
      button.addEventListener("click", () => {
        filterButtons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");

        const filter = button.dataset.filter;
        portfolioItems.forEach((item) => {
          const matches = filter === "all" || item.classList.contains(filter);
          item.classList.toggle("hide", !matches);
        });
      });
    });
  }

  const openModal = (item) => {
    if (!portfolioModal || !modalTitle || !modalImage || !modalDesc || !modalLink) return;

    modalTitle.textContent = item.dataset.title || "";
    modalDesc.textContent = item.dataset.desc || "";
    modalLink.href = item.dataset.link || "#";

    const image = item.querySelector("img");
    if (image) {
      modalImage.src = image.src;
      modalImage.alt = image.alt || "Project preview";
    }

    portfolioModal.style.display = "flex";
    portfolioModal.classList.add("show");
    portfolioModal.setAttribute("aria-hidden", "false");
  };

  const closeModal = () => {
    if (!portfolioModal) return;
    portfolioModal.classList.remove("show");
    portfolioModal.setAttribute("aria-hidden", "true");
    history.pushState("", document.title, window.location.pathname);
    setTimeout(() => {
      if (portfolioModal) portfolioModal.style.display = "none";
    }, 300);
  };

  if (portfolioItems.length && portfolioModal) {
    portfolioItems.forEach((item) => {
      item.addEventListener("click", () => {
        const id = item.dataset.id;
        openModal(item);
        if (id) history.pushState(null, "", `#${id}`);
      });
    });
  }

  if (modalClose) {
    modalClose.addEventListener("click", closeModal);
  }

  if (portfolioModal) {
    portfolioModal.addEventListener("click", (event) => {
      if (event.target === portfolioModal) {
        closeModal();
      }
    });
  }

  window.addEventListener("load", () => {
    const hash = window.location.hash.replace("#", "");
    if (!hash) return;
    const project = document.querySelector(`[data-id="${hash}"]`);
    if (project) {
      openModal(project);
    }
  });
}

// --- Contact Form ---
function initContactForm() {
  const contactForm = document.querySelector("#contactForm");
  if (!contactForm) return;

  contactForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const successMsg = document.getElementById("successMessage");
    const errorMsg = document.getElementById("errorMessage");
    const submitBtn = contactForm.querySelector("button[type='submit']");

    if (successMsg) successMsg.style.display = "none";
    if (errorMsg) errorMsg.style.display = "none";

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = "Sending...";
    }

    const data = {
      first_name: document.getElementById("firstName")?.value || "",
      last_name: document.getElementById("lastName")?.value || "",
      email: document.getElementById("email")?.value || "",
      phone: document.getElementById("phone")?.value || "",
      message: document.getElementById("message")?.value || ""
    };

    try {
      const response = await fetch("api/contact.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (result.success) {
        if (successMsg) successMsg.style.display = "block";
        contactForm.reset();

        if (submitBtn) {
          submitBtn.textContent = "Send Message";
          submitBtn.disabled = false;
        }

        setTimeout(() => {
          if (successMsg) successMsg.style.display = "none";
        }, 3000);
      } else {
        if (errorMsg) {
          errorMsg.textContent = result.error || "Error sending message";
          errorMsg.style.display = "block";
        }
        if (submitBtn) {
          submitBtn.textContent = "Send Message";
          submitBtn.disabled = false;
        }
      }
    } catch (error) {
      if (errorMsg) {
        errorMsg.textContent = "Error: Could not connect to the server.";
        errorMsg.style.display = "block";
      }
      if (submitBtn) {
        submitBtn.textContent = "Send Message";
        submitBtn.disabled = false;
      }
    }
  });
}
