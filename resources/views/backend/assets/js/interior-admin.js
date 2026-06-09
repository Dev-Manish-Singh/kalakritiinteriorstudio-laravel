(function () {
  const imagePool = [
    "images/product/a-lg.jpg",
    "images/product/a.jpg",
    "images/product/b.jpg",
    "images/product/c.jpg",
    "images/product/d.jpg",
    "images/product/e.jpg",
    "images/product/f.jpg",
    "images/product/g.jpg"
  ];

  const modules = {
    banners: {
      title: "Banner Management",
      singular: "Banner",
      addUrl: "banner-form.html",
      listUrl: "banners.html",
      filters: ["All Status", "Active", "Inactive"],
      columns: ["Banner", "Title", "Subtitle", "Order", "Status"],
      rows: [
        ["Homepage Hero", "Warm Minimalist Living", "Refined neutral interiors", "01", "Active"],
        ["Kitchen Feature", "Luxury Modular Kitchen", "Tailored details for everyday rituals", "02", "Active"],
        ["Apartment Promo", "Studio Apartment Makeover", "Compact plans with premium texture", "03", "Inactive"]
      ],
      fields: ["Banner Image", "Title", "Subtitle", "Button Text", "Button Link", "Display Order", "Status"]
    },
    testimonials: {
      title: "Testimonial Management",
      singular: "Testimonial",
      addUrl: "testimonial-form.html",
      listUrl: "testimonials.html",
      filters: ["All Ratings", "5 Star", "4 Star", "Active"],
      columns: ["Client", "Designation", "Rating", "Message", "Status"],
      rows: [
        ["Aarav Mehta", "Villa Owner", "5", "The team translated our brief into a home that feels deeply personal.", "Active"],
        ["Nisha Rao", "Founder, Rao Studio", "5", "Material choices, lighting, and storage planning were handled beautifully.", "Active"],
        ["Karan Shah", "Penthouse Owner", "4", "Elegant design direction with clear communication at every step.", "Inactive"]
      ],
      fields: ["Client Image", "Client Name", "Designation", "Rating", "Testimonial Message", "Status"]
    },
    services: {
      title: "Services Management",
      singular: "Service",
      addUrl: "service-form.html",
      listUrl: "services.html",
      filters: ["All Services", "Residential", "Commercial", "Active"],
      columns: ["Service", "Slug", "Short Description", "Meta Title", "Status"],
      rows: [
        ["Residential Interior Design", "residential-interior-design", "End-to-end planning for homes, apartments, and villas.", "Residential Interior Design Studio", "Active"],
        ["Turnkey Execution", "turnkey-execution", "Procurement, site coordination, and styling in one managed flow.", "Turnkey Interior Execution", "Active"],
        ["Commercial Space Design", "commercial-space-design", "Premium offices, retail stores, and hospitality environments.", "Commercial Interior Designers", "Inactive"]
      ],
      fields: ["Service Image", "Service Name", "Slug", "Short Description", "Detailed Description", "Key Features", "Meta Title", "Meta Description", "Status"]
    },
    projects: {
      title: "Project Management",
      singular: "Project",
      addUrl: "project-form.html",
      listUrl: "projects.html",
      filters: ["All Categories", "Residential", "Commercial", "Featured"],
      columns: ["Project", "Category", "Location", "Budget", "Status"],
      rows: [
        ["Urban Loft Transformation", "Residential", "Mumbai", "INR 42L - 55L", "Published"],
        ["Boutique Office Lounge", "Commercial", "Pune", "INR 28L - 35L", "Published"],
        ["Modern Villa Styling", "Residential", "Ahmedabad", "INR 70L - 90L", "Draft"]
      ],
      fields: ["Project Name", "Slug", "Category", "Location", "Area/Size", "Budget Range", "Completion Date", "Main Image", "Before Images", "After Images", "Gallery Images", "Short Description", "Full Description", "Challenges", "Design Solution", "Materials Used", "Featured Project", "Meta Title", "Meta Description", "Status"]
    },
    gallery: {
      title: "Gallery Management",
      singular: "Gallery Image",
      addUrl: "gallery-form.html",
      listUrl: "gallery.html",
      filters: ["All Categories", "Living Room", "Bedroom", "Kitchen"],
      columns: ["Image", "Title", "Category", "Display Order", "Status"],
      rows: [
        ["Walnut Living Room", "Living Room", "Living Room", "01", "Active"],
        ["Muted Bedroom Suite", "Bedroom", "Bedroom", "02", "Active"],
        ["Stone Finish Kitchen", "Kitchen", "Kitchen", "03", "Inactive"]
      ],
      fields: ["Image", "Image Title", "Category", "Alt Text", "Display Order", "Status"]
    },
    blogs: {
      title: "Blog Management",
      singular: "Blog",
      addUrl: "blog-form.html",
      listUrl: "blogs.html",
      filters: ["All Posts", "Draft", "Published", "Design Tips"],
      columns: ["Blog", "Category", "Author", "Publish Date", "Status"],
      rows: [
        ["How to Layer Neutrals", "Design Tips", "Meera Kapoor", "2026-05-12", "Published"],
        ["Choosing Stone Finishes", "Materials", "Rohan Iyer", "2026-05-08", "Draft"],
        ["Small Apartment Storage Ideas", "Planning", "Meera Kapoor", "2026-04-28", "Published"]
      ],
      fields: ["Blog Title", "Slug", "Category", "Featured Image", "Short Description", "Full Blog Content", "Author Name", "Publish Date", "Tags", "Status Draft/Published", "Meta Title", "Meta Description", "Meta Keywords"]
    }
  };

  const stats = [
    ["Total Banners", "08", "ni-img"],
    ["Total Testimonials", "24", "ni-chat-circle"],
    ["Total Services", "12", "ni-setting"],
    ["Total Projects", "36", "ni-building"],
    ["Total Gallery Images", "148", "ni-grid-alt"],
    ["Total Blogs", "42", "ni-file-text"]
  ];

  const toggle = document.querySelector(".ia-menu-toggle");
  if (toggle) toggle.addEventListener("click", () => document.body.classList.toggle("ia-sidebar-open"));

  const statRoot = document.getElementById("dashboardStats");
  if (statRoot) {
    statRoot.innerHTML = stats.map(([label, count, icon]) => `
      <article class="ia-stat-card">
        <em class="icon ni ${icon}"></em>
        <strong>${count}</strong>
        <span>${label}</span>
      </article>
    `).join("");
  }

  const listRoot = document.getElementById("moduleList");
  if (listRoot) renderList(listRoot.dataset.module, listRoot);

  const formRoot = document.getElementById("moduleForm");
  if (formRoot) renderForm(formRoot.dataset.module, formRoot);

  initPreviewInputs();

  function renderList(key, root) {
    const module = modules[key];
    if (!module) return;
    document.title = `Interior Studio Admin - ${module.title}`;
    setText("pageTitle", module.title);
    setText("pageKicker", `${module.singular} listing`);
    const add = document.getElementById("addButton");
    if (add) add.href = module.addUrl;

    root.innerHTML = `
      <div class="ia-list-toolbar">
        <div class="d-flex gap-2 flex-wrap">
          <select class="form-select">${module.filters.map(item => `<option>${item}</option>`).join("")}</select>
        </div>
        <button class="btn btn-outline-dark" type="button"><em class="icon ni ni-filter"></em><span>Apply Filter</span></button>
      </div>
      <div class="card ia-card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-middle ia-table datatable-init" data-show-per-page="2" data-nk-container="table-responsive">
              <thead><tr>${module.columns.map(col => `<th>${col}</th>`).join("")}<th class="text-end">Actions</th></tr></thead>
              <tbody>${module.rows.map((row, index) => renderRow(module, row, index)).join("")}</tbody>
            </table>
          </div>
        </div>
      </div>`;
  }

  function renderRow(module, row, index) {
    const status = row[row.length - 1];
    const badgeClass = status.toLowerCase().includes("draft") ? "draft" : status.toLowerCase().includes("inactive") ? "inactive" : "active";
    const cells = row.map((cell, cellIndex) => {
      if (cellIndex === 0) {
        return `<td><div class="media-group"><img class="ia-thumb" src="${imagePool[index % imagePool.length]}" alt="${cell}"><div class="media-text"><a class="title" href="${module.addUrl}">${cell}</a><span class="small text-muted">${module.singular} details</span></div></div></td>`;
      }
      if (cellIndex === row.length - 1) return `<td><span class="ia-badge ${badgeClass}">${cell}</span></td>`;
      if (module.singular === "Testimonial" && cellIndex === 2) return `<td><span class="fw-bold">${cell}/5</span></td>`;
      return `<td>${cell}</td>`;
    }).join("");
    return `<tr>${cells}<td class="text-end"><div class="ia-action-group"><a class="btn btn-sm btn-outline-dark" href="${module.addUrl}" title="View"><em class="icon ni ni-eye"></em></a><a class="btn btn-sm btn-outline-dark" href="${module.addUrl}" title="Edit"><em class="icon ni ni-edit"></em></a><button class="btn btn-sm btn-outline-danger" type="button" title="Delete"><em class="icon ni ni-trash"></em></button></div></td></tr>`;
  }

  function renderForm(key, root) {
    const module = modules[key];
    if (!module) return;
    document.title = `Interior Studio Admin - Add ${module.singular}`;
    setText("pageTitle", `Add / Edit ${module.singular}`);
    setText("pageKicker", `${module.title}`);
    const cancel = document.getElementById("cancelButton");
    if (cancel) cancel.href = module.listUrl;

    root.innerHTML = module.fields.map((field, index) => renderField(field, index)).join("");
  }

  function renderField(field, index) {
    const lower = field.toLowerCase();
    const full = lower.includes("description") || lower.includes("message") || lower.includes("content") || lower.includes("features") || lower.includes("challenges") || lower.includes("solution") || lower.includes("materials") || lower.includes("links") || lower.includes("address") || lower.includes("footer") ? " full" : "";
    if (lower.includes("image") || lower.includes("logo")) {
      return `<div class="full"><label class="form-label">${field}</label><input class="form-control ia-preview-input" type="file" accept="image/*" data-preview="preview-${index}"><div class="ia-upload-preview mt-2" id="preview-${index}"><img src="${imagePool[index % imagePool.length]}" alt="${field} preview"></div></div>`;
    }
    if (lower === "status") {
      return `<div><label class="form-label">${field}</label><div class="form-check form-switch mt-2"><input class="form-check-input" type="checkbox" role="switch" checked><label class="form-check-label">Active</label></div></div>`;
    }
    if (lower.includes("status draft/published") || lower.includes("category") || lower.includes("rating") || lower.includes("featured")) {
      const options = lower.includes("rating") ? ["5", "4", "3", "2", "1"] : lower.includes("featured") ? ["Yes", "No"] : lower.includes("category") ? ["Residential", "Commercial", "Living Room", "Bedroom", "Kitchen", "Design Tips"] : ["Active", "Inactive", "Draft", "Published"];
      return `<div class="${full.trim()}"><label class="form-label">${field}</label><select class="form-select">${options.map(option => `<option>${option}</option>`).join("")}</select></div>`;
    }
    if (lower.includes("date")) return `<div><label class="form-label">${field}</label><input class="form-control" type="date" value="2026-05-19"></div>`;
    if (full) return `<div class="full"><label class="form-label">${field}</label><textarea class="form-control" rows="4" placeholder="Enter ${field.toLowerCase()}"></textarea></div>`;
    return `<div><label class="form-label">${field}</label><input class="form-control" type="text" placeholder="Enter ${field.toLowerCase()}"></div>`;
  }

  function initPreviewInputs() {
    document.querySelectorAll(".ia-preview-input").forEach(input => {
      input.addEventListener("change", event => {
        const file = event.target.files && event.target.files[0];
        const preview = document.getElementById(event.target.dataset.preview);
        if (!file || !preview) return;
        const img = preview.querySelector("img") || document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.innerHTML = "";
        preview.appendChild(img);
      });
    });
  }

  function setText(id, text) {
    const node = document.getElementById(id);
    if (node) node.textContent = text;
  }
})();
