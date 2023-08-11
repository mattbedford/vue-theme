<template>
    <div class="about page-wrap">
      <section class="section1 stretch">
        <div class="col col1">
            <h1 class="section-title">404</h1>
            <div>
                <h3>Ooooh no!</h3>
                <p>The page you were looking for does not exist. Really sorry.</p>
            </div>
            <router-link :to="{name: '/'}"><button class="btn">Head back to the homepage</button></router-link>
        </div>
        <div class="col col2">
            <img class="page-image" src="/wp-content/uploads/pexels-andrea-piacquadio-3772618.jpg" alt="Dagorà reports image" />
        </div>
      </section>
    </div>
  </template>