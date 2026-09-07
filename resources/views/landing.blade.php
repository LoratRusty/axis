<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AXIS - Entrenamiento Comercial Advance</title>
<meta name="description" content="AXIS transforma vendedores en Asesores Comerciales certificados en 12 meses. Sistema de entrenamiento con evidencia, seguimiento semanal y feedback estructurado.">
<meta name="robots" content="index, follow">
<meta property="og:title" content="AXIS - Entrenamiento Comercial Advance">
<meta property="og:description" content="El vendedor es dueño de su propia historia de desempeño.">
<meta property="og:type" content="website">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,700;1,9..144,300;1,9..144,500;1,9..144,700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --cream:#FAF8F4;
  --cream-dark:#F0EDE6;
  --cream-border:#E5E0D5;
  --navy:#1B2F6E;
  --navy-light:#243E8F;
  --sky:#5BB8E8;
  --coral:#E84444;
  --ink:#1A1A1A;
  --ink-mid:#444444;
  --ink-soft:#767676;
  --white:#FFFFFF;
  --f-serif:'Fraunces',Georgia,serif;
  --f-sans:'Plus Jakarta Sans',system-ui,sans-serif;
}
html{scroll-behavior:smooth}
body{font-family:var(--f-sans);background:var(--cream);color:var(--ink);overflow-x:hidden;-webkit-font-smoothing:antialiased}

/* NAV */
.nav{
  position:fixed;top:0;left:0;right:0;z-index:99;
  padding:1.25rem 2.5rem;
  display:flex;align-items:center;justify-content:space-between;
  transition:all .3s;
}
.nav.scrolled{
  background:rgba(250,248,244,0.95);
  backdrop-filter:blur(10px);
  border-bottom:1px solid var(--cream-border);
}
.nav-brand{display:flex;align-items:center;gap:.75rem;text-decoration:none}
.nav-logo{
  width:36px;height:36px;background:var(--navy);
  display:flex;align-items:center;justify-content:center;
  font-family:var(--f-serif);font-weight:700;font-size:1rem;color:var(--white);
}
.nav-name{font-family:var(--f-serif);font-size:1.2rem;font-weight:700;color:var(--navy);letter-spacing:-.01em}
.nav-right{display:flex;align-items:center;gap:2rem}
.nav-link{font-size:.92rem;font-weight:500;color:var(--ink-mid);text-decoration:none;transition:color .2s}
.nav-link:hover{color:var(--navy)}
.nav-btn{
  font-family:var(--f-sans);font-size:.88rem;font-weight:700;
  color:var(--white);background:var(--navy);
  padding:.6rem 1.4rem;text-decoration:none;border-radius:6px;
  transition:background .2s,transform .2s;
}
.nav-btn:hover{background:var(--navy-light);transform:translateY(-1px)}

/* HERO */
.hero{
  min-height:100svh;
  background:var(--cream);
  display:flex;flex-direction:column;justify-content:center;
  padding:9rem 2.5rem 5rem;
  max-width:100%;margin:0;
  position:relative;
  overflow:hidden;
}
.hero-tag{
  display:inline-flex;align-items:center;gap:.6rem;
  font-size:.75rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;
  color:var(--navy);margin-bottom:2rem;
  opacity:0;animation:fadeUp .7s ease .1s forwards;
}
.hero-tag span{
  width:6px;height:6px;border-radius:50%;background:var(--sky);
  display:inline-block;
}
.hero-h1{
  font-family:var(--f-serif);
  font-size:clamp(3rem,7vw,6.5rem);
  font-weight:700;line-height:1.0;
  letter-spacing:-.03em;
  color:var(--ink);
  margin-bottom:2rem;
  opacity:0;animation:fadeUp .8s ease .2s forwards;
}
.hero-h1 .warm{color:var(--navy)}
.hero-h1 .italic{font-style:italic;font-weight:300;color:var(--ink-mid)}
.hero-h1 .highlight{color:var(--navy)}
.hero-row{
  display:grid;grid-template-columns:1fr 1fr;gap:4rem;
  align-items:end;
  opacity:0;animation:fadeUp .8s ease .35s forwards;
}
@media(max-width:700px){.hero-row{grid-template-columns:1fr;gap:2rem}}
.hero-body{
  font-size:1.15rem;line-height:1.8;color:var(--ink-mid);font-weight:300;
  border-left:3px solid var(--sky);padding-left:1.25rem;
}
.hero-actions{display:flex;flex-direction:column;gap:1rem;align-items:flex-start}
.btn-navy{
  font-size:.9rem;font-weight:700;color:var(--white);background:var(--navy);
  padding:.9rem 2rem;border-radius:8px;text-decoration:none;
  display:inline-flex;align-items:center;gap:.5rem;
  transition:all .2s;
}
.btn-navy:hover{background:var(--navy-light);transform:translateY(-2px);box-shadow:0 8px 24px rgba(27,47,110,.2)}
.btn-text{
  font-size:.92rem;font-weight:500;color:var(--ink-mid);text-decoration:none;
  display:inline-flex;align-items:center;gap:.4rem;
  border-bottom:1px solid var(--cream-border);padding-bottom:.2rem;
  transition:color .2s,border-color .2s;
}
.btn-text:hover{color:var(--navy);border-color:var(--navy)}
.hero-scroll-hint{
  margin-top:4rem;display:flex;align-items:center;gap:.75rem;
  font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-mid);
  opacity:0;animation:fadeIn 1s ease 1.2s forwards;
}
.hero-scroll-hint::before{content:'';width:40px;height:1px;background:var(--cream-border)}

/* TRUST BAR */
.trust{
  background:var(--navy);
  padding:1.25rem 2.5rem;
  display:flex;align-items:center;justify-content:center;gap:3rem;
  flex-wrap:wrap;
}
.trust-item{
  font-size:.78rem;font-weight:600;letter-spacing:.06em;
  color:rgba(255,255,255,.5);text-transform:uppercase;
  display:flex;align-items:center;gap:.6rem;
}
.trust-item::before{content:'';width:4px;height:4px;border-radius:50%;background:var(--sky)}

/* NUMEROS */
.numeros{
  padding:5rem 2.5rem;
  background:var(--white);
  border-bottom:1px solid var(--cream-border);
}
.numeros-inner{
  max-width:1200px;margin:0 auto;
  display:grid;grid-template-columns:repeat(4,1fr);gap:0;
}
@media(max-width:700px){.numeros-inner{grid-template-columns:repeat(2,1fr)}}
.num-cell{
  padding:2.5rem 2rem;
  border-right:1px solid var(--cream-border);
  text-align:left;
}
.num-cell:last-child{border-right:none}
.num-val{
  font-family:var(--f-serif);
  font-size:clamp(2.5rem,4vw,3.5rem);
  font-weight:700;color:var(--navy);
  line-height:1;margin-bottom:.5rem;letter-spacing:-.02em;
}
.num-val sup{font-size:.45em;vertical-align:super;color:var(--sky);font-weight:500}
.num-lbl{font-size:.88rem;color:var(--ink-mid);font-weight:400;line-height:1.5}

/* PROBLEMA */
.problema{
  padding:7rem 2.5rem;
  background:var(--cream);
}
.problema-inner{max-width:1200px;margin:0 auto}
.problema-header{
  display:grid;grid-template-columns:5fr 3fr;gap:4rem;
  align-items:end;margin-bottom:4rem;
}
@media(max-width:700px){.problema-header{grid-template-columns:1fr}}
.section-label{
  font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:var(--sky);margin-bottom:1rem;
  display:flex;align-items:center;gap:.5rem;
}
.section-label::before{content:'';width:24px;height:1.5px;background:var(--sky)}
.h2{
  font-family:var(--f-serif);
  font-size:clamp(1.9rem,3.5vw,2.8rem);
  font-weight:700;line-height:1.15;letter-spacing:-.02em;
  color:var(--ink);
}
.problema-intro{
  font-size:.95rem;color:var(--ink-mid);line-height:1.8;font-weight:300;
  border-top:1px solid var(--cream-border);padding-top:1.5rem;
}
.problema-grid{
  display:grid;grid-template-columns:1fr 1fr;gap:1px;
  background:var(--cream-border);border:1px solid var(--cream-border);
}
@media(max-width:700px){.problema-grid{grid-template-columns:1fr}}
.problema-item{
  background:var(--white);padding:2rem;
  display:flex;flex-direction:column;gap:.75rem;
}
.p-icon{
  width:36px;height:36px;border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;
}
.p-icon.red{background:#FEF2F2}
.p-icon.blue{background:#EFF8FF}
.p-icon.red svg{color:var(--coral)}
.p-icon.blue svg{color:var(--sky)}
.p-icon svg{width:18px;height:18px}
.p-title{font-size:.95rem;font-weight:700;color:var(--ink)}
.p-desc{font-size:.92rem;color:var(--ink-mid);line-height:1.65;font-weight:300}

/* PROCESO */
.proceso{
  padding:7rem 2.5rem;
  background:var(--cream-dark);
}
.proceso-inner{max-width:1200px;margin:0 auto}
.proceso-head{
  display:grid;grid-template-columns:1fr 1fr;gap:4rem;
  align-items:end;margin-bottom:4rem;
}
@media(max-width:700px){.proceso-head{grid-template-columns:1fr}}
.proceso-sub{font-size:.95rem;color:var(--ink-mid);line-height:1.8;font-weight:300}
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem}
@media(max-width:860px){.steps{grid-template-columns:1fr 1fr}}
@media(max-width:500px){.steps{grid-template-columns:1fr}}
.step{
  background:var(--white);
  border:1px solid var(--cream-border);
  border-radius:12px;padding:2rem 1.75rem;
  transition:all .25s;position:relative;overflow:hidden;
}
.step:hover{border-color:var(--navy);transform:translateY(-3px);box-shadow:0 12px 32px rgba(27,47,110,.1)}
.step-n{
  font-family:var(--f-serif);font-size:.8rem;font-weight:500;
  color:var(--sky);margin-bottom:1.25rem;
}
.step-icon{
  width:44px;height:44px;border-radius:10px;
  background:var(--cream);
  display:flex;align-items:center;justify-content:center;
  margin-bottom:1.25rem;
  transition:background .25s;
}
.step:hover .step-icon{background:var(--navy)}
.step:hover .step-icon svg{color:var(--white)}
.step-icon svg{width:20px;height:20px;color:var(--navy);transition:color .25s}
.step-title{font-size:1.05rem;font-weight:700;color:var(--ink);margin-bottom:.6rem}
.step-desc{font-size:.9rem;color:var(--ink-mid);line-height:1.65;font-weight:300}

/* ROLES */
.roles{
  padding:7rem 2.5rem;
  background:var(--white);
}
.roles-inner{max-width:1200px;margin:0 auto}
.roles-head{
  display:flex;align-items:flex-end;justify-content:space-between;
  gap:2rem;margin-bottom:3.5rem;flex-wrap:wrap;
}
.roles-sub{font-size:.95rem;color:var(--ink-mid);font-weight:300;line-height:1.7;max-width:380px}
.roles-grid{
  display:grid;grid-template-columns:repeat(3,1fr);
  gap:1.5rem;
}
@media(max-width:860px){.roles-grid{grid-template-columns:1fr}}
.role{
  border:1px solid var(--cream-border);
  border-radius:12px;padding:2.5rem 2rem;
  text-decoration:none;display:flex;flex-direction:column;
  background:var(--white);
  transition:all .25s;
}
.role:hover{
  border-color:var(--navy);
  box-shadow:0 16px 40px rgba(27,47,110,.12);
  transform:translateY(-4px);
}
.role-badge{
  font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:var(--navy);background:#EEF2FF;
  padding:.3rem .7rem;border-radius:4px;
  display:inline-block;margin-bottom:1.5rem;width:fit-content;
}
.role-title{
  font-family:var(--f-serif);font-size:1.6rem;font-weight:700;
  color:var(--ink);letter-spacing:-.01em;margin-bottom:.75rem;
}
.role-desc{font-size:.95rem;color:var(--ink-mid);line-height:1.7;font-weight:300;margin-bottom:1.5rem;flex:1}
.role-list{list-style:none;margin-bottom:2rem;display:flex;flex-direction:column;gap:.5rem}
.role-list li{
  font-size:.88rem;color:var(--ink-mid);
  padding:.45rem 0;border-bottom:1px solid var(--cream-border);
  display:flex;align-items:center;gap:.6rem;
}
.role-list li:last-child{border-bottom:none}
.role-list li::before{content:'';width:5px;height:5px;border-radius:50%;background:var(--sky);flex-shrink:0}
.role-cta{
  display:inline-flex;align-items:center;gap:.5rem;
  font-size:.88rem;font-weight:700;color:var(--navy);
  margin-top:auto;transition:gap .2s;
}
.role:hover .role-cta{gap:.8rem}

/* FORMULA */
.formula{
  padding:7rem 2.5rem;
  background:var(--navy);
  position:relative;overflow:hidden;
}
.formula::before{
  content:'AXIS';
  position:absolute;right:-2rem;top:50%;transform:translateY(-50%);
  font-family:var(--f-serif);font-weight:700;
  font-size:18rem;color:rgba(255,255,255,.03);
  letter-spacing:-.05em;pointer-events:none;line-height:1;
}
.formula-inner{max-width:1100px;margin:0 auto;position:relative;z-index:2}
.formula-label{
  font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:rgba(255,255,255,.6);margin-bottom:1.5rem;
}
.formula-title{
  font-family:var(--f-serif);
  font-size:clamp(2rem,4vw,3.2rem);
  font-weight:700;color:var(--white);
  letter-spacing:-.02em;line-height:1.1;margin-bottom:3.5rem;
}
.formula-title em{font-style:italic;font-weight:300;color:rgba(255,255,255,.55)}
.formula-eq{
  display:flex;align-items:stretch;
  border:1px solid rgba(255,255,255,.1);
  border-radius:12px;overflow:hidden;
  flex-wrap:wrap;
}
.ft{
  flex:1;min-width:160px;padding:2rem 1.75rem;
  border-right:1px solid rgba(255,255,255,.08);
  background:rgba(255,255,255,.03);
  transition:background .25s;
}
.ft:hover{background:rgba(255,255,255,.07)}
.ft:last-child{border-right:none;background:rgba(91,184,232,.1)}
.ft-tag{font-size:.65rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:.6rem}
.ft-val{font-family:var(--f-serif);font-size:1.3rem;font-weight:700;color:var(--white);letter-spacing:-.01em}
.ft-val.sky{color:var(--sky);font-size:1.5rem}
.ft-op{
  display:flex;align-items:center;justify-content:center;
  padding:0 .75rem;
  font-size:1.5rem;color:rgba(255,255,255,.15);
  background:transparent;flex-shrink:0;
}
.formula-note{
  margin-top:2.5rem;padding-top:2rem;
  border-top:1px solid rgba(255,255,255,.08);
  font-size:.9rem;color:rgba(255,255,255,.75);line-height:1.8;font-weight:300;
  max-width:600px;
}

/* CTA */
.cta{
  padding:8rem 2.5rem;
  background:var(--cream);
}
.cta-inner{max-width:1200px;margin:0 auto}
.cta-box{
  background:var(--white);border:1px solid var(--cream-border);
  border-radius:20px;padding:5rem 4rem;
  display:grid;grid-template-columns:1fr 1fr;gap:5rem;
  align-items:center;
}
@media(max-width:700px){.cta-box{grid-template-columns:1fr;padding:3rem 2rem;gap:2.5rem}}
.cta-title{
  font-family:var(--f-serif);
  font-size:clamp(2.2rem,4vw,3.5rem);
  font-weight:700;letter-spacing:-.03em;
  color:var(--ink);line-height:1.1;margin-bottom:1.5rem;
}
.cta-title em{font-style:italic;font-weight:300;color:var(--navy)}
.cta-body{font-size:.95rem;color:var(--ink-mid);line-height:1.8;font-weight:300}
.accesos{display:flex;flex-direction:column;gap:1rem}
.acceso{
  display:flex;align-items:center;justify-content:space-between;
  padding:1.25rem 1.5rem;
  border:1px solid var(--cream-border);border-radius:10px;
  text-decoration:none;background:var(--cream);
  transition:all .2s;
}
.acceso:hover{background:var(--navy);border-color:var(--navy)}
.acceso:hover .ac-role{color:var(--white)}
.acceso:hover .ac-label{color:rgba(255,255,255,.45)}
.acceso:hover .ac-arrow{color:var(--sky)}
.ac-left{display:flex;flex-direction:column;gap:.2rem}
.ac-role{font-size:.95rem;font-weight:700;color:var(--ink);transition:color .2s}
.ac-label{font-size:.75rem;color:var(--ink-mid);font-weight:300;transition:color .2s}
.ac-arrow{font-size:.9rem;color:var(--ink-mid);transition:color .2s}

/* FOOTER */
footer{
  background:var(--ink);padding:2.5rem;
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;
}
.foot-l{font-family:var(--f-serif);font-size:.9rem;font-weight:700;color:rgba(255,255,255,.4)}
.foot-r{font-size:.78rem;color:rgba(255,255,255,.25);font-weight:300}
.foot-r a{color:var(--sky);text-decoration:none}

/* ANIMATIONS */
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
</style>
</head>
<body>

<!-- NAV -->
<nav class="nav" id="nav">
  <a href="/" class="nav-brand">
    <div class="nav-logo">A</div>
    <span class="nav-name">AXIS</span>
  </a>
  <div class="nav-right">
    <a href="#proceso" class="nav-link">Como funciona</a>
    <a href="#acceso" class="nav-link">Acceder</a>
    <a href="/mi-programa/login" class="nav-btn">Entrar →</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">

    {{-- Imagen de fondo --}}
    <div style="position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1600&q=80&auto=format&fit=crop');background-size:cover;background-position:center;opacity:0.12;pointer-events:none;z-index:0;"></div>
    <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(250,248,244,0.7) 0%, rgba(250,248,244,0.3) 60%, transparent 100%);pointer-events:none;z-index:0;"></div>
    {{-- Contenido --}}
    <div style="position:relative;z-index:1;max-width:1200px;margin:0 auto;width:100%">
        <div class="hero-tag"><span></span>Advance - Sistema de Entrenamiento Comercial</div>
        <h1 class="hero-h1">
            El vendedor<br>
            <span class="italic">es dueño</span><br>
            <span class="highlight">de su historia.</span>
        </h1>
        <div class="hero-row">
            <p class="hero-body">
                AXIS convierte cada semana de trabajo en evidencia trazable de capacidad comercial. De trainee a Asesor Comercial certificado en 12 meses - con estructura, seguimiento y feedback real.
            </p>
            <div class="hero-actions">
                <a href="/mi-programa/login" class="btn-navy">
                    Entrar a mi programa
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <a href="#proceso" class="btn-text">
                    Ver como funciona
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3"/></svg>
                </a>
            </div>
        </div>
    </div>

</section>

<!-- TRUST BAR -->
<div class="trust">
  <div class="trust-item">55 años de historia</div>
  <div class="trust-item">1,200+ organizaciones</div>
  <div class="trust-item">28,500+ productos</div>
  <div class="trust-item">Latinoamerica</div>
  <div class="trust-item">12 meses de entrenamiento</div>
</div>

<!-- NUMEROS -->
<section class="numeros">
  <div class="numeros-inner">
    <div class="num-cell" data-aos="fade-up" data-aos-delay="0">
      <div class="num-val"><span class="counter" data-target="55">0</span><sup>años</sup></div>
      <div class="num-lbl">de historia en Latinoamerica</div>
    </div>
    <div class="num-cell" data-aos="fade-up" data-aos-delay="80">
      <div class="num-val"><span class="counter" data-target="1200">0</span><sup>+</sup></div>
      <div class="num-lbl">organizaciones en la region</div>
    </div>
    <div class="num-cell" data-aos="fade-up" data-aos-delay="160">
      <div class="num-val"><span class="counter" data-target="28">0</span><sup>k+</sup></div>
      <div class="num-lbl">productos en catalogo</div>
    </div>
    <div class="num-cell" data-aos="fade-up" data-aos-delay="240">
      <div class="num-val"><span class="counter" data-target="12">0</span><sup>meses</sup></div>
      <div class="num-lbl">para certificar un Asesor Comercial</div>
    </div>
  </div>
</section>

<!-- PROBLEMA / SOLUCION -->
<section class="problema">
  <div class="problema-inner">
    <div class="problema-header" data-aos="fade-up">
      <div>
        <div class="section-label">El problema y la solucion</div>
        <h2 class="h2">Sin visibilidad del progreso, no existe desarrollo comercial real.</h2>
      </div>
      <p class="problema-intro">Los equipos de ventas crecen sin estructura. El talento se pierde porque nadie mide lo que realmente importa semana a semana.</p>
    </div>
    <div class="problema-grid" data-aos="fade-up" data-aos-delay="100">
      <div class="problema-item">
        <div class="p-icon red">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="p-title">Sin visibilidad del progreso</div>
        <div class="p-desc">El avance del vendedor no se mide semana a semana. Nadie sabe con certeza en que punto esta ni que le falta para subir de nivel.</div>
      </div>
      <div class="problema-item">
        <div class="p-icon blue">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="p-title">Dashboard con semaforo semanal</div>
        <div class="p-desc">El trainee ve en tiempo real cuantas interacciones validas lleva, cuantas evidencias subio y cuantos dias faltan para el corte.</div>
      </div>
      <div class="problema-item">
        <div class="p-icon red">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="p-title">Feedback informal sin impacto</div>
        <div class="p-desc">Las conversaciones de coaching no quedan registradas, no tienen estructura y raramente generan un cambio de comportamiento concreto.</div>
      </div>
      <div class="problema-item">
        <div class="p-icon blue">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="p-title">Feedback con una sola accion</div>
        <div class="p-desc">Cada sesion queda registrada con fortalezas, brechas y una sola accion de mejora verificable. El trainee confirma que lo leyo.</div>
      </div>
      <div class="problema-item">
        <div class="p-icon red">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="p-title">Ascensos por percepcion</div>
        <div class="p-desc">Las decisiones de promocion se basan en impresiones subjetivas, no en evidencia objetiva del desempeno acumulado del vendedor.</div>
      </div>
      <div class="problema-item">
        <div class="p-icon blue">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="p-title">Ascensos respaldados por datos</div>
        <div class="p-desc">El coach recomienda, gerencia aprueba. Cada decision tiene detras un expediente completo con KPIs, evidencias y rubricas.</div>
      </div>
    </div>
  </div>
</section>

<!-- PROCESO -->
<section class="proceso" id="proceso">
  <div class="proceso-inner">
    <div class="proceso-head" data-aos="fade-up">
      <div>
        <div class="section-label">Como funciona</div>
        <h2 class="h2">Un ciclo semanal que construye capacidad.</h2>
      </div>
      <p class="proceso-sub">Cuatro acciones que se repiten cada semana. Cada iteracion deposita evidencia en el expediente del vendedor hasta certificarlo.</p>
    </div>
    <div class="steps">
      <div class="step" data-aos="fade-up" data-aos-delay="0">
        <div class="step-n">Paso 01</div>
        <div class="step-icon">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25M3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0l3.869-1.934A1.125 1.125 0 0021 17.82V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689A1.125 1.125 0 003 6.695z"/></svg>
        </div>
        <div class="step-title">Planifica</div>
        <div class="step-desc">El trainee construye su Matriz de Planificacion con las visitas de la semana, priorizando cuentas segun la etapa del programa.</div>
      </div>
      <div class="step" data-aos="fade-up" data-aos-delay="80">
        <div class="step-n">Paso 02</div>
        <div class="step-icon">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
        </div>
        <div class="step-title">Ejecuta</div>
        <div class="step-desc">Visitas presenciales con metodologia SPICED. Registro de interacciones validas y evidencias fisicas que respaldan cada visita.</div>
      </div>
      <div class="step" data-aos="fade-up" data-aos-delay="160">
        <div class="step-n">Paso 03</div>
        <div class="step-icon">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
        </div>
        <div class="step-title">Verifica</div>
        <div class="step-desc">El coach evalua evidencias, aprueba o solicita correccion y entrega feedback estructurado con una sola accion de mejora verificable.</div>
      </div>
      <div class="step" data-aos="fade-up" data-aos-delay="240">
        <div class="step-n">Paso 04</div>
        <div class="step-icon">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
        </div>
        <div class="step-title">Actua</div>
        <div class="step-desc">Se ajusta la estrategia, se acreditan sub-roles cuando se cumplen los criterios y gerencia aprueba el ascenso con datos reales.</div>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="roles" id="acceso">
  <div class="roles-inner">
    <div class="roles-head" data-aos="fade-up">
      <div>
        <div class="section-label">Acceso por rol</div>
        <h2 class="h2">Un sistema,<br>tres perspectivas.</h2>
      </div>
      <p class="roles-sub">Cada usuario tiene su propio espacio con la informacion y las herramientas que necesita para su rol.</p>
    </div>
    <div class="roles-grid">
      <a href="/mi-programa/login" class="role" data-aos="fade-up" data-aos-delay="0">
        <span class="role-badge">Trainee</span>
        <div class="role-title">Mi Programa</div>
        <p class="role-desc">Tu espacio personal para registrar evidencias, interacciones y seguir tu trayectoria de sub-roles semana a semana.</p>
        <ul class="role-list">
          <li>Semaforo semanal en tiempo real</li>
          <li>Registro de interacciones de campo</li>
          <li>Carga de evidencias por ritual</li>
          <li>Feedback del coach con confirmacion</li>
          <li>Expediente profesional propio</li>
        </ul>
        <div class="role-cta">Entrar a mi programa <span>→</span></div>
      </a>
      <a href="/coach/login" class="role" data-aos="fade-up" data-aos-delay="100">
        <span class="role-badge">Coach Comercial</span>
        <div class="role-title">Panel Coach</div>
        <p class="role-desc">Gestion completa de tu equipo. Revisa evidencias, emite feedback estructurado y acredita sub-roles con datos reales.</p>
        <ul class="role-list">
          <li>Dashboard del equipo en tiempo real</li>
          <li>Revision y aprobacion de evidencias</li>
          <li>Sesiones de feedback estructuradas</li>
          <li>Acreditacion de sub-roles</li>
          <li>Recomendacion de ascenso a gerencia</li>
        </ul>
        <div class="role-cta">Entrar al panel <span>→</span></div>
      </a>
      <a href="/manager/login" class="role" data-aos="fade-up" data-aos-delay="200">
        <span class="role-badge">Gerencia</span>
        <div class="role-title">Vista Ejecutiva</div>
        <p class="role-desc">KPIs consolidados, alertas de riesgo y flujo de aprobacion de ascenso. Decisiones con datos y expedientes completos.</p>
        <ul class="role-list">
          <li>Dashboard ejecutivo con KPIs</li>
          <li>Alertas de trainees en riesgo</li>
          <li>Flujo de aprobacion de ascenso</li>
          <li>Vista de todos los programas activos</li>
          <li>Historial de graduados</li>
        </ul>
        <div class="role-cta">Entrar al panel <span>→</span></div>
      </a>
    </div>
  </div>
</section>

<!-- FORMULA -->
<section class="formula">
  <div class="formula-inner" data-aos="fade-up">
    <div class="formula-label">La formula del programa</div>
    <h2 class="formula-title">Lo que convierte actividad<br><em>en capacidad comercial real.</em></h2>
    <div class="formula-eq">
      <div class="ft">
        <div class="ft-tag">Elemento 01</div>
        <div class="ft-val sky">Herramienta</div>
      </div>
      <div class="ft-op">+</div>
      <div class="ft">
        <div class="ft-tag">Elemento 02</div>
        <div class="ft-val">Habito</div>
      </div>
      <div class="ft-op">+</div>
      <div class="ft">
        <div class="ft-tag">Elemento 03</div>
        <div class="ft-val">Habilidad</div>
      </div>
      <div class="ft-op">=</div>
      <div class="ft">
        <div class="ft-tag">Resultado</div>
        <div class="ft-val sky">Capacidad Comercial</div>
      </div>
    </div>
    <p class="formula-note">
      Cada ritual, cada evidencia y cada sesion de feedback esta disenada para desarrollar estos tres elementos de forma simultanea. AXIS es el sistema que estructura ese proceso hasta certificar un Asesor Comercial.
    </p>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta">
  <div class="cta-inner" data-aos="fade-up">
    <div class="cta-box">
      <div>
        <h2 class="cta-title">Empieza a construir<br><em>tu historia</em><br>hoy mismo.</h2>
        <p class="cta-body">Accede a tu espacio en AXIS segun tu rol. Todo lo que necesitas para desarrollar o gestionar el talento comercial de Advance esta aqui.</p>
      </div>
      <div class="accesos">
        <a href="/mi-programa/login" class="acceso">
          <div class="ac-left">
            <div class="ac-role">Soy Trainee</div>
            <div class="ac-label">Portal de seguimiento personal</div>
          </div>
          <div class="ac-arrow">→</div>
        </a>
        <a href="/coach/login" class="acceso">
          <div class="ac-left">
            <div class="ac-role">Soy Coach</div>
            <div class="ac-label">Gestion del equipo</div>
          </div>
          <div class="ac-arrow">→</div>
        </a>
        <a href="/manager/login" class="acceso">
          <div class="ac-left">
            <div class="ac-role">Soy Gerente</div>
            <div class="ac-label">Vista ejecutiva y ascensos</div>
          </div>
          <div class="ac-arrow">→</div>
        </a>
        <a href="/admin/login" class="acceso">
          <div class="ac-left">
            <div class="ac-role">Administrador</div>
            <div class="ac-label">Configuracion del sistema</div>
          </div>
          <div class="ac-arrow">→</div>
        </a>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="foot-l">AXIS - Advance</div>
  <div class="foot-r">
    <a href="https://somosadvance.com" target="_blank" rel="noopener">somosadvance.com</a>
    &nbsp;·&nbsp; &copy; {{ date('Y') }} Todos los derechos reservados
  </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({duration:680,easing:'ease-out-quart',once:true,offset:60});
const nav=document.getElementById('nav');
window.addEventListener('scroll',()=>nav.classList.toggle('scrolled',scrollY>60),{passive:true});
const counters=document.querySelectorAll('.counter');
const io=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(!e.isIntersecting)return;
    const el=e.target,target=+el.dataset.target,dur=1600;
    let cur=0,step=target/(dur/16);
    const t=setInterval(()=>{
      cur=Math.min(cur+step,target);
      el.textContent=Math.floor(cur).toLocaleString('es');
      if(cur>=target)clearInterval(t);
    },16);
    io.unobserve(el);
  });
},{threshold:.5});
counters.forEach(c=>io.observe(c));
</script>
</body>
</html>