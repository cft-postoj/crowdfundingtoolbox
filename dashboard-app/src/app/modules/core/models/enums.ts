export var backgroundTypes = {
    color: {name: "Color", value: "color"},
    image: {name: "Image", value: "image"},
    imageOverlay: {name: "Image with color overlay", value: "image-overlay"}
}

export var devices = {
    desktop: {
        name: "desktop"
    },
    mobile: {
        name: "mobile"
    },
    tablet: {
        name: "tablet"
    }
}

export var paymentTypes = {
    monthly: {title: "Monthly", value: "monthly"},
    once: {title: "Once", value: "once"},
    both: {title: "Both options", value: "both"},
}

export var paymentMethods = {
    bankTransfer: {title: "Bank transfer", value: "bank_transfer"},
    creditCard: {title: "Credit card", value: "credit_card"},
    payBySquare: {title: "Pay by square", value: "pay_by_square"},
    googlePay: {title: "Google Pay", value: "google_pay"},
    applePay: {title: "Apple Pay", value: "apple_pay"}

}

export var widgetTypes = {
    landing: {
        name: 'landing',
        method: 'landing'
    },
    sidebar: {
        name: 'sidebar',
        method: 'sidebar'
    },
    leaderboard: {
        name: 'leaderboard',
        method: 'leaderboard'
    },
    popup: {
        name: 'popup',
        method: 'popup'
    },
    fixed: {
        name: 'fixed',
        method: 'fixed'
    },
    locked: {
        name: 'locked',
        method: 'locked'
    },
    article: {
        name: 'article',
        method: 'article'
    },
    article_link: {
        name: 'article_link',
        method: 'article_link'
    },
    custom: {
        name: 'custom',
        method: 'custom'
    },
    article_advanced: {
        name: 'article_advanced',
        method: 'article_advanced'
    }
}

export var sidebarType = {
    stats: {
        title: 'Stats'
    },
    campaigns: {
        title: 'Campagins'
    }

}