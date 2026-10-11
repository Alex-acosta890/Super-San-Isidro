<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alimentos San Isidro — Panel de control</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/estailos.css?v=<?php echo filemtime('../css/estailos.css'); ?>">
</head>
<body>

<!-- ===== Iconos (sprite) ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <symbol id="i-home" viewBox="0 0 24 24"><path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></symbol>
    <symbol id="i-cart" viewBox="0 0 24 24"><path d="M3 4h2l1.5 10h11L20 7H6"/><circle cx="9" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/></symbol>
    <symbol id="i-flame" viewBox="0 0 24 24"><path d="M12 3c1 3.5 5 5 5 10a5 5 0 0 1-10 0c0-2 1-3.2 2-4 0 2 1 3 2 3 0-3-1-5 1-9z"/></symbol>
    <symbol id="i-package" viewBox="0 0 24 24"><path d="M3.5 8 12 4l8.5 4v8L12 20l-8.5-4V8z"/><path d="M3.5 8 12 12l8.5-4M12 12v8"/></symbol>
    <symbol id="i-box" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="5" rx="1"/><path d="M5 9v10h14V9M10 13h4"/></symbol>
    <symbol id="i-swap" viewBox="0 0 24 24"><path d="M7 7h13l-3-3M17 17H4l3 3"/></symbol>
    <symbol id="i-tag" viewBox="0 0 24 24"><path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.2"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="M12 3 3 8l9 5 9-5z"/><path d="M3 13l9 5 9-5"/></symbol>
    <symbol id="i-book" viewBox="0 0 24 24"><path d="M5 4h11a3 3 0 0 1 3 3v13H8a3 3 0 0 1-3-3z"/><path d="M5 17a3 3 0 0 1 3-3h11"/></symbol>
    <symbol id="i-gift" viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M5 12v9h14v-9M12 8v13"/><path d="M12 8c-3 0-4-4-1.5-4S12 8 12 8zM12 8c3 0 4-4 1.5-4S12 8 12 8z"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><path d="M12 3 2 20h20z"/><path d="M12 10v4M12 17v.5"/></symbol>
    <symbol id="i-truck" viewBox="0 0 24 24"><path d="M2 6h11v10H2zM13 9h4l4 3v4h-8z"/><circle cx="6" cy="18" r="1.6"/><circle cx="17" cy="18" r="1.6"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.8-3.5 3.3-5 6.5-5s5.7 1.5 6.5 5M16 4.5a3.5 3.5 0 0 1 0 7M18 15c2 .6 3.3 2.2 3.5 5"/></symbol>
    <symbol id="i-receipt" viewBox="0 0 24 24"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></symbol>
    <symbol id="i-cash" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><rect x="13" y="13" width="7" height="7" rx="1"/></symbol>
    <symbol id="i-ruler" viewBox="0 0 24 24"><path d="M3 15 15 3l6 6L9 21z"/><path d="m8 10 2 2M11 7l2 2M5 13l2 2"/></symbol>
    <symbol id="i-shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/></symbol>
    <symbol id="i-chart" viewBox="0 0 24 24"><path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-3"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m21 21-3.5-3.5"/></symbol>
    <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 9a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 13 6 9z"/><path d="M9.5 17a2.5 2.5 0 0 0 5 0"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="i-logout" viewBox="0 0 24 24"><path d="M15 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"/><path d="M10 12h11m0 0-3.2-3.2M21 12l-3.2 3.2"/></symbol>
  </defs>
</svg>

<div class="app">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="brand">
      <span class="brand-mark">SI</span>
      <div class="brand-text">
        <span class="brand-name">San Isidro</span>
        <span class="brand-sub">Gestión integral</span>
      </div>
    </div>

    <nav class="nav">
      <a class="nav-item is-active" href="#panel">
        <svg class="ic"><use href="#i-home"/></svg><span>Panel</span>
      </a>

      <span class="nav-label">Operaciones</span>
      <a class="nav-item" href="#compras"><svg class="ic"><use href="#i-cart"/></svg><span>Compras</span></a>
      <a class="nav-item" href="#produccion-primaria"><svg class="ic"><use href="#i-flame"/></svg><span>Producción primaria</span></a>
      <a class="nav-item" href="#produccion-secundaria"><svg class="ic"><use href="#i-package"/></svg><span>Producción secundaria</span></a>
      <a class="nav-item" href="#ventas"><svg class="ic"><use href="#i-cash"/></svg><span>Ventas</span></a>
      <a class="nav-item" href="#facturas"><svg class="ic"><use href="#i-receipt"/></svg><span>Facturas</span></a>

      <span class="nav-label">Inventario</span>
      <a class="nav-item" href="inventario.html">
  <svg class="ic"><use href="#i-box"/></svg>
  <span>Existencias</span>
</a>
      <a class="nav-item" href="#movimientos"><svg class="ic"><use href="#i-swap"/></svg><span>Movimientos</span></a>
      <a class="nav-item" href="#lotes"><svg class="ic"><use href="#i-tag"/></svg><span>Lotes</span></a>
      <a class="nav-item" href="#items"><svg class="ic"><use href="#i-layers"/></svg><span>Ítems</span></a>
      <a class="nav-item" href="#recetas"><svg class="ic"><use href="#i-book"/></svg><span>Recetas</span></a>
      <a class="nav-item" href="#regalias"><svg class="ic"><use href="#i-gift"/></svg><span>Regalías</span></a>
      <a class="nav-item" href="#mermas"><svg class="ic"><use href="#i-alert"/></svg><span>Mermas</span></a>

      <span class="nav-label">Terceros</span>
      <a class="nav-item" href="#proveedores"><svg class="ic"><use href="#i-truck"/></svg><span>Proveedores</span></a>
      <a class="nav-item" href="#clientes"><svg class="ic"><use href="#i-users"/></svg><span>Clientes</span></a>

      <span class="nav-label">Configuración</span>
      <a class="nav-item" href="#categorias"><svg class="ic"><use href="#i-grid"/></svg><span>Categorías</span></a>
      <a class="nav-item" href="#unidades"><svg class="ic"><use href="#i-ruler"/></svg><span>Unidades de medida</span></a>
      <a class="nav-item" href="#usuarios"><svg class="ic"><use href="#i-shield"/></svg><span>Usuarios y roles</span></a>
      <a class="nav-item" href="#reportes"><svg class="ic"><use href="#i-chart"/></svg><span>Reportes y costos</span></a>
    </nav>

    <div class="sidebar-foot">
      <div class="user-box">
         <!--- 
        <div class="user-avatar">A</div>
        <div class="user-data">
        <div class="user-name">Doña Marina</div> 
          <div class="user-role">Administrador</div>*/
        </div>
        -->
      </div>
      <a class="nav-item nav-exit" href="../../controllers/Logout.php">
        <svg class="ic"><use href="#i-logout"/></svg><span>Cerrar sesión</span>
      </a>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <header class="topbar">
      <div class="search">
        <svg class="ic"><use href="#i-search"/></svg>
        <input type="text" placeholder="Buscar ítem, lote, proveedor o cliente…">
      </div>
      <div class="topbar-right">
        <button class="icon-btn" aria-label="Notificaciones">
          <svg class="ic"><use href="#i-bell"/></svg>
          <span class="dot"></span>
        </button>
        <div class="avatar">A</div>
      </div>
    </header>

    <!-- Bienvenida + accesos rápidos -->
    <section class="banner">
      <div class="banner-copy">
        <span class="eyebrow">Resumen del día</span>
        <h1>Que onda, Alex 😊.<br>Así va la operación de hoy.</h1>
        <p>Hay <strong>2 lotes por vencer</strong> y <strong>3 ítems</strong> con existencia baja.</p>
        <div class="quick-actions">
          <a class="btn btn-primary" href="#compras-nueva"><svg class="ic"><use href="#i-plus"/></svg>Nueva compra</a>
          <a class="btn btn-ghost" href="#produccion-nueva"><svg class="ic"><use href="#i-plus"/></svg>Nueva producción</a>
          <a class="btn btn-ghost" href="#ventas-nueva"><svg class="ic"><use href="#i-plus"/></svg>Nueva venta</a>
          <a class="btn btn-ghost" href="#mermas-nueva"><svg class="ic"><use href="#i-plus"/></svg>Registrar merma</a>
        </div>
      </div>
      <div class="banner-ring">
        <svg viewBox="0 0 120 120" class="ring-svg">
          <circle cx="60" cy="60" r="50" class="ring-track"/>
          <circle cx="60" cy="60" r="50" class="ring-value"/>
        </svg>
        <div class="ring-text">
          <span class="ring-number">82%</span>
          <span class="ring-label">salud de inventario</span>
        </div>
      </div>
    </section>

    <!-- Indicadores -->
    <section class="stats-row">
      <div class="stat-card">
        <span class="stat-label">Existencia de café (kg)</span>
        <span class="stat-number">1,240</span>
        <span class="stat-trend up">+180 kg esta semana</span>
      </div>
      <div class="stat-card">
        <span class="stat-label">Ventas del mes</span>
        <span class="stat-number">C$ 86,420</span>
        <span class="stat-trend up">+12% vs mes anterior</span>
      </div>
      <div class="stat-card">
        <span class="stat-label">Compras del mes</span>
        <span class="stat-number">C$ 41,300</span>
        <span class="stat-trend">9 compras registradas</span>
      </div>
      <div class="stat-card stat-card-warn">
        <span class="stat-label">Mermas del mes</span>
        <span class="stat-number">14 kg</span>
        <span class="stat-trend down">Revisar causas</span>
      </div>
    </section>

    <!-- Flujo del negocio -->
    <section class="panel panel-light">
      <div class="panel-head">
        <div>
          <h2>Flujo del negocio</h2>
          <p class="panel-sub">De la compra a la venta, todo pasa por el inventario</p>
        </div>
      </div>
      <ol class="flow">
        <li class="flow-step">
          <svg class="ic"><use href="#i-cart"/></svg>
          <span class="flow-title">Compras</span>
          <span class="flow-num">9</span>
          <span class="flow-meta">este mes</span>
        </li>
        <li class="flow-step">
          <svg class="ic"><use href="#i-flame"/></svg>
          <span class="flow-title">Prod. primaria</span>
          <span class="flow-num">5</span>
          <span class="flow-meta">tostados / molidos</span>
        </li>
        <li class="flow-step">
          <svg class="ic"><use href="#i-package"/></svg>
          <span class="flow-title">Prod. secundaria</span>
          <span class="flow-num">4</span>
          <span class="flow-meta">empacados</span>
        </li>
        <li class="flow-step">
          <svg class="ic"><use href="#i-box"/></svg>
          <span class="flow-title">Inventario</span>
          <span class="flow-num">62</span>
          <span class="flow-meta">ítems con existencia</span>
        </li>
        <li class="flow-step">
          <svg class="ic"><use href="#i-cash"/></svg>
          <span class="flow-title">Ventas</span>
          <span class="flow-num">31</span>
          <span class="flow-meta">este mes</span>
        </li>
      </ol>
    </section>

    <!-- Contenido -->
    <section class="grid">

      <!-- Movimientos -->
      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Últimos movimientos de inventario</h2>
            <p class="panel-sub">Cada cambio queda registrado</p>
          </div>
          <a class="panel-link" href="#movimientos">Ver todos</a>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Ítem</th>
                <th>Lote</th>
                <th class="num">Cantidad</th>
                <th>Usuario</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>10/10 08:15</td>
                <td><span class="pill pill-in">Compra</span></td>
                <td>Café verde</td>
                <td class="mono">L-0142</td>
                <td class="num in">+300 kg</td>
                <td>Marina</td>
              </tr>
              <tr>
                <td>09/10 15:40</td>
                <td><span class="pill pill-prod">Producción</span></td>
                <td>Café tostado</td>
                <td class="mono">L-0143</td>
                <td class="num in">+240 kg</td>
                <td>Carlos</td>
              </tr>
              <tr>
                <td>09/10 11:05</td>
                <td><span class="pill pill-out">Venta</span></td>
                <td>Café molido 1 lb</td>
                <td class="mono">L-0139</td>
                <td class="num out">−48 uds</td>
                <td>Marina</td>
              </tr>
              <tr>
                <td>08/10 16:20</td>
                <td><span class="pill pill-gift">Regalía</span></td>
                <td>Café molido 1 lb</td>
                <td class="mono">L-0139</td>
                <td class="num out">−12 uds</td>
                <td>Marina</td>
              </tr>
              <tr>
                <td>08/10 09:30</td>
                <td><span class="pill pill-loss">Merma</span></td>
                <td>Café tostado</td>
                <td class="mono">L-0138</td>
                <td class="num out">−6 kg</td>
                <td>Carlos</td>
              </tr>
              <tr>
                <td>07/10 14:10</td>
                <td><span class="pill pill-adj">Ajuste</span></td>
                <td>Etiquetas</td>
                <td class="mono">—</td>
                <td class="num out">−20 uds</td>
                <td>Marina</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Columna derecha -->
      <div class="panel-stack">

        <div class="panel">
          <div class="panel-head">
            <div>
              <h2>Existencia baja</h2>
              <p class="panel-sub">Reponer o producir pronto</p>
            </div>
            <span class="badge badge-danger">3</span>
          </div>
          <ul class="stock-list">
            <li class="stock-row">
              <span class="stock-dot dot-danger"></span>
              <div class="stock-info">
                <span class="stock-name">Bolsas 1 lb</span>
                <span class="stock-meta">Materia prima · Empaque</span>
              </div>
              <span class="stock-qty">0 uds</span>
            </li>
            <li class="stock-row">
              <span class="stock-dot dot-warn"></span>
              <div class="stock-info">
                <span class="stock-name">Etiquetas</span>
                <span class="stock-meta">Materia prima · Empaque</span>
              </div>
              <span class="stock-qty">35 uds</span>
            </li>
            <li class="stock-row">
              <span class="stock-dot dot-warn"></span>
              <div class="stock-info">
                <span class="stock-name">Café molido 1 lb</span>
                <span class="stock-meta">Producto terminado</span>
              </div>
              <span class="stock-qty">18 uds</span>
            </li>
          </ul>
        </div>

        <div class="panel">
          <div class="panel-head">
            <div>
              <h2>Lotes por vencer</h2>
              <p class="panel-sub">Próximos 30 días</p>
            </div>
            <a class="panel-link" href="#lotes">Ver lotes</a>
          </div>
          <ul class="stock-list">
            <li class="stock-row">
              <span class="stock-dot dot-warn"></span>
              <div class="stock-info">
                <span class="stock-name">Café molido 1 lb</span>
                <span class="stock-meta mono">L-0131</span>
              </div>
              <span class="stock-qty">Vence 24/10</span>
            </li>
            <li class="stock-row">
              <span class="stock-dot dot-warn"></span>
              <div class="stock-info">
                <span class="stock-name">Café tostado</span>
                <span class="stock-meta mono">L-0128</span>
              </div>
              <span class="stock-qty">Vence 02/11</span>
            </li>
          </ul>
        </div>

        <div class="panel">
          <div class="panel-head">
            <div>
              <h2>Proveedores recientes</h2>
              <p class="panel-sub">Últimas compras</p>
            </div>
            <a class="panel-link" href="#proveedores">Ver todos</a>
          </div>
          <ul class="provider-list">
            <li class="provider-row">
              <span class="provider-avatar">FM</span>
              <div class="provider-info">
                <span class="provider-name">Finca Los Mangos</span>
                <span class="provider-meta">Café verde · 10/10</span>
              </div>
            </li>
            <li class="provider-row">
              <span class="provider-avatar">EC</span>
              <div class="provider-info">
                <span class="provider-name">Empaques Centroamérica</span>
                <span class="provider-meta">Bolsas y etiquetas · 03/10</span>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </section>

  </main>
</div>
</body>
</html>