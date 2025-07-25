// جلب البيانات من data.js
function renderOpportunities(opps) {
  const container = document.getElementById("opportunityList");
  container.innerHTML = "";

  if (opps.length === 0) {
    container.innerHTML = "<p>لا توجد فرص مطابقة للبحث الحالي.</p>";
    return;
  }

  opps.forEach((item) => {
    const card = document.createElement("div");
    card.className = "opportunity-card";

    const deadline = new Date(item.lastDate).getTime();
    const now = new Date().getTime();
    const timeLeft = deadline - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
    const isExpired = timeLeft < 0;

    card.innerHTML = `
      <div class="card-header ${item.status === 'منتهية' ? 'ended' : 'active'}">
        ${item.status}
      </div>
      <h3>${item.name}</h3>
      <p>📍 <strong>الموقع:</strong> ${item.location}</p>
      <p>📐 <strong>المساحة:</strong> ${item.area}</p>
      <p>⏱ <strong>مدة العقد:</strong> ${item.duration}</p>
      <p>🗓 <strong>آخر موعد:</strong> ${new Date(item.lastDate).toLocaleDateString("ar-EG")}</p>
      ${
        isExpired
          ? `<p class="expired">⛔ انتهى التقديم</p>`
          : `<p class="countdown">⏳ متبقي: ${days} يوم / ${hours} ساعة / ${minutes} دقيقة</p>`
      }
      <div class="tags">
        <span>${item.type}</span>
        <span>${item.status}</span>
      </div>
      <div class="buttons">
        <a href="opportunity.html?id=${item.id}" class="details">عرض التفاصيل</a>
        <a href="${item.map}" target="_blank" class="map">عرض الخريطة</a>
      </div>
    `;
    container.appendChild(card);
  });
}

function applyFilters() {
  const search = document.getElementById("search").value.trim();
  const type = document.getElementById("typeFilter").value;
  const location = document.getElementById("locationFilter").value;
  const status = document.getElementById("statusFilter").value;

  const filtered = opportunities.filter((item) => {
    const matchSearch =
      item.name.includes(search) || item.location.includes(search);
    const matchType = !type || item.type === type;
    const matchLocation = !location || item.location === location;
    const matchStatus = !status || item.status === status;
    return matchSearch && matchType && matchLocation && matchStatus;
  });

  renderOpportunities(filtered);
}

// عرض جميع الفرص عند بداية الصفحة
window.onload = () => {
  renderOpportunities(opportunities);
};
