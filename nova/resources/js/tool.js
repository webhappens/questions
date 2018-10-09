Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'questions',
            path: '/questions',
            component: require('./components/Tool'),
        },
    ])
})
