<template>
    hello BOYS
    <nav>
        <div>
            <router-link :to="{name: 'CheckClothing'}">Hey hey</router-link>
            <router-link to="/user/CheckClothing"> WHT</router-link>
        </div>
    </nav>
    <main>
        <router-view/>
    </main>
</template>