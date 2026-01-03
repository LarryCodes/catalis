<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Catalis HR')</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  @stack('styles')
  @livewireStyles
</head>

<body data-path="{{ request()->path() }}">
  <div class="dashboard">
    <aside class="sidebar">
      <div class="nav-icon" data-key="workflow">
        <img src="{{ asset('images/layer-group-solid.svg') }}" alt="Workflow">
      </div>
      <div class="nav-icon" data-key="preferences">
        <img src="{{ asset('images/preferences.svg') }}" alt="Preferences">
      </div>
      <br>
      <div class="nav-icon" data-key="settings">
        <img src="{{ asset('images/sliders-solid.svg') }}" alt="Settings">
      </div>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      <div class="nav-icon" data-key="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <img src="{{ asset('images/logout.svg') }}" alt="Logout">
      </div>
    </aside>

    <section class="sub-menu">
      <div class="profile-card">
        <img src="{{ asset('images/profile.jpg') }}" alt="Profile Picture" class="profile-avatar">
        <div class="profile-info">
          <div class="user-fullname">{{ auth()->user()->name ?? 'Administrator' }}</div>
          <div class="user-title">{{ auth()->user()->roles->first()?->name ?? 'User' }}</div>
        </div>
      </div>
      <hr>
      <div id="menu-container"></div>
    </section>

    <div class="calendar-widget">
      <div class="calendar-add-event" style="display: flex; align-items: center; gap: 5px; font-weight: 500;"></div>
      <div class="calendar-header">
        <h3 class="calendar-month-year" id="monthYear"></h3>
        <div class="calendar-nav-container">
          <button class="calendar-nav" id="prevMonth">‹</button>
          <button class="calendar-nav" id="nextMonth">›</button>
        </div>
      </div>
      <div class="calendar-grid">
        <div class="calendar-day-header weekend">Su</div>
        <div class="calendar-day-header">Mo</div>
        <div class="calendar-day-header">Tu</div>
        <div class="calendar-day-header">We</div>
        <div class="calendar-day-header">Th</div>
        <div class="calendar-day-header">Fr</div>
        <div class="calendar-day-header weekend">Sa</div>
        <div class="calendar-days" id="calendarDays"></div>
      </div>
    </div>

    <main class="main-container">
      <section class="content">
        @yield('content')
      </section>
    </main>
  </div>

  @livewireScripts
  <script>
    const staticBaseUrl = "{{ asset('images') }}/";
    const menus = {
      workflow: [{
          label: 'Employee Portal',
          icon: 'id.svg',
          children: [{
              label: 'My Tasks'
            },
            {
              label: 'Leave & Absence'
            },
            {
              label: 'Approvals'
            },
            {
              label: 'Career Development',
              children: [{
                  label: 'Personal Learning'
                },
                {
                  label: 'Appraisal'
                },
              ]
            }
          ]
        },
        {
          label: 'People & Talent',
          icon: 'people.svg',
          children: [{
              label: 'Our People'
            },
            {
              label: 'Talent Acquisition'
            },
            {
              label: 'Attendance & Payrolls',
              children: [{
                  label: 'Time & Attendance'
                },
                {
                  label: 'Payroll Management'
                }
              ]
            },
            {
              label: 'Knowledge & Resource Hub'
            },
            {
              label: 'Performance & Appraisals',
              children: [{
                label: 'KPIs & Metrics'
              }]
            },
          ]
        },
        {
          label: 'Compliance & Risk',
          icon: 'incident.svg',
          children: [{
              label: 'Policy Management'
            },
            {
              label: 'Conduct & Conflict Resolution'
            },
          ]
        },
        {
          label: 'People Analytics',
          icon: 'analytics.svg',
          children: [{
              label: 'People Dashboard'
            },
            {
              label: 'Reports'
            }
          ]
        }
      ],
      preferences: [{
          label: 'Accounts & Access',
          icon: 'user.svg',
          children: [{
              label: 'Account Management',
              href: '/accounts'
            }
          ]
        },
        {
          label: 'Tabular Data',
          icon: 'table.svg',
          children: [{
              label: 'Our People'
            },
            {
              label: 'Attendance & Payrolls'
            },
            {
              label: 'Performance & Appraisals'
            },
            {
              label: 'Knowledge & Resource Hub'
            }
          ]
        }
      ]
    };

    const container = document.getElementById('menu-container');
    const iconElements = document.querySelectorAll('.nav-icon');

    function renderMenu(key) {
      container.innerHTML = '';
      const items = menus[key];
      if (!items) return;

      items.forEach((item) => {
        const dropdown = document.createElement('div');
        dropdown.className = 'dropdown';

        const toggle = document.createElement('button');
        toggle.className = 'dropdown-toggle';

        const icon = document.createElement('img');
        icon.src = item.icon ? `${staticBaseUrl}${item.icon}` : '';
        icon.alt = '';
        icon.className = 'menu-icon';

        const label = document.createElement('span');
        label.textContent = item.label;

        toggle.appendChild(icon);
        toggle.appendChild(label);
        dropdown.appendChild(toggle);

        if (item.children) {
          const menu = document.createElement('div');
          menu.className = 'dropdown-menu';
          menu.style.display = 'none';

          item.children.forEach(child => {
            const childLabel = typeof child === 'string' ? child : child.label || '';
            const childHref = typeof child === 'object' && child.href ? child.href : 'javascript:void(0)';
            const link = document.createElement('a');
            link.href = childHref;
            link.textContent = childLabel;

            if (child.children && child.children.length > 0) {
              const subMenu = document.createElement('div');
              subMenu.className = 'dropdown-menu';
              subMenu.style.display = 'none';

              child.children.forEach(grandchild => {
                const grandChildLink = document.createElement('a');
                grandChildLink.href = 'javascript:void(0)';
                grandChildLink.textContent = grandchild.label || '';
                subMenu.appendChild(grandChildLink);
              });

              link.appendChild(subMenu);
            }

            menu.appendChild(link);
          });

          dropdown.appendChild(menu);

          toggle.addEventListener('click', e => {
            e.stopPropagation();
            const isVisible = menu.style.display === 'block';
            const allDropdowns = container.querySelectorAll('.dropdown');
            allDropdowns.forEach(dropdown => {
              const siblingMenu = dropdown.querySelector('.dropdown-menu');
              const siblingToggle = dropdown.querySelector('.dropdown-toggle');

              if (siblingMenu && siblingMenu !== menu) {
                siblingMenu.style.display = 'none';
                siblingMenu.classList.remove('active');
              }

              if (siblingToggle && siblingToggle !== toggle) {
                siblingToggle.classList.remove('active');
              }
            });

            if (!isVisible) {
              menu.style.display = 'block';
              toggle.classList.add('active');
            } else {
              menu.style.display = 'none';
              toggle.classList.remove('active');
            }
          });
        }

        container.appendChild(dropdown);
      });

      attachChildLinkListeners();
    }

    function attachChildLinkListeners() {
      container.querySelectorAll('.dropdown-menu a').forEach(link => {
        link.addEventListener('click', e => {
          e.preventDefault();
          e.stopPropagation();

          const nestedMenu = link.querySelector('.dropdown-menu');

          if (nestedMenu) {
            const isVisible = nestedMenu.style.display === 'block';
            nestedMenu.style.display = isVisible ? 'none' : 'block';
            return;
          }

          const siblings = Array.from(link.parentElement.children)
            .filter(el => el.tagName === 'A');
          siblings.forEach(sib => sib.classList.remove('active'));

          link.classList.add('active');

          const label = link.textContent.trim();
          const routes = {
            'Our People': '{{ url('/people') }}',
            'Time & Attendance': '{{ url('/time-attendance') }}',
            'Payroll Management': '{{ url('/payroll') }}',
            'Account Management': '{{ url('/accounts') }}'
          };

          const path = routes[label];
          if (path) {
            const activeIcon = document.querySelector('.nav-icon.active');
            const sectionKey = activeIcon ? activeIcon.dataset.key : 'home';
            const fullPath = [sectionKey, label].join('/');
            localStorage.setItem('menuPath', fullPath);

            window.location.href = path;
          }
        });
      });
    }

    iconElements.forEach(icon => {
      icon.addEventListener('click', () => {
        iconElements.forEach(i => i.classList.remove('active'));
        icon.classList.add('active');

        const key = icon.dataset.key;
        if (key === 'logout') {
          return;
        }

        renderMenu(key);
      });
    });

    window.addEventListener('DOMContentLoaded', () => {
      let sectionKey = 'workflow';
      let subPath = '';
      let grandChildPath = '';

      const savedPath = localStorage.getItem('menuPath');
      if (savedPath) {
        const segments = savedPath.split('/');
        sectionKey = segments[0] || 'workflow';
        subPath = segments[1]?.toLowerCase();
        grandChildPath = segments[2]?.toLowerCase();
      }

      const targetIcon = document.querySelector(`.nav-icon[data-key="${sectionKey}"]`);
      if (targetIcon) {
        document.querySelectorAll('.nav-icon').forEach(i => i.classList.remove('active'));
        targetIcon.classList.add('active');
        renderMenu(sectionKey);

        setTimeout(() => {
          const links = container.querySelectorAll('.dropdown-menu a');

          links.forEach(link => {
            const label = link.textContent.trim().toLowerCase();
            if (label === subPath || label === grandChildPath) {
              link.classList.add('active');

              let menu = link.closest('.dropdown-menu');
              while (menu) {
                menu.style.display = 'block';

                let toggle = menu.previousElementSibling;
                if (!toggle || !toggle.classList.contains('dropdown-toggle')) {
                  const dropdown = menu.closest('.dropdown');
                  if (dropdown) {
                    toggle = dropdown.querySelector('.dropdown-toggle');
                  }
                }

                if (toggle && toggle.classList.contains('dropdown-toggle')) {
                  toggle.classList.add('active');
                }

                menu = menu.parentElement.closest('.dropdown-menu');
              }
            }
          });
        }, 0);
      }
    });

    class Calendar {
      constructor() {
        this.currentDate = new Date();
        this.monthNames = [
          'January', 'February', 'March', 'April', 'May', 'June',
          'July', 'August', 'September', 'October', 'November', 'December'
        ];
        this.init();
      }

      init() {
        this.renderCalendar();
        this.attachEventListeners();
      }

      renderCalendar() {
        const monthYearElement = document.getElementById('monthYear');
        const calendarDaysElement = document.getElementById('calendarDays');

        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();

        monthYearElement.textContent = `${this.monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();

        const firstDayOfWeek = firstDay.getDay();

        calendarDaysElement.innerHTML = '';

        for (let i = 0; i < firstDayOfWeek; i++) {
          const emptyDay = document.createElement('div');
          emptyDay.className = 'calendar-day empty';
          calendarDaysElement.appendChild(emptyDay);
        }

        for (let day = 1; day <= daysInMonth; day++) {
          const dayElement = document.createElement('div');
          dayElement.className = 'calendar-day';
          dayElement.textContent = day;

          const dayOfWeek = new Date(year, month, day).getDay();
          if (dayOfWeek === 0 || dayOfWeek === 6) {
            dayElement.classList.add('weekend');
          }

          const today = new Date();
          if (year === today.getFullYear() &&
            month === today.getMonth() &&
            day === today.getDate()) {
            dayElement.classList.add('today');
          }

          calendarDaysElement.appendChild(dayElement);
        }
      }

      attachEventListeners() {
        document.getElementById('prevMonth').addEventListener('click', () => {
          this.currentDate.setMonth(this.currentDate.getMonth() - 1);
          this.renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
          this.currentDate.setMonth(this.currentDate.getMonth() + 1);
          this.renderCalendar();
        });

        document.getElementById('monthYear').addEventListener('click', () => {
          this.currentDate = new Date();
          this.renderCalendar();
        });
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      new Calendar();
    });
  </script>
  @stack('scripts')
</body>

</html>
