class Cart {
    constructor() {
        this.showTotalPay()
    }
    get(id = null) {
        let data = JSON.parse(localStorage.getItem('cart'))
        if (id == null) {
            return data
        }else {
            if (data != null) {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].id == id) {
                        return data[i]
                    }
                }
            }
        }
    }
    toIdr(angka) {
        var rupiah = ''
        var angkarev = angka.toString().split('').reverse().join('')
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.'
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('')
    }
    showTotalPay() {
        let cart = this.get()
        let price = 0
        if (cart != null) {
            for (let i = 0; i < cart.length; i++) {
                price += cart[i].totalPay
            }
        }
        
        let areaTotal = document.querySelector("#areaTotal")
        if (areaTotal !== null) {
            document.querySelector("#areaTotal").innerText = this.toIdr(price)
        }
    }
    dataExists(productID, cart) {
        if (cart == null) return false
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id == productID) return cart[i]
        }
    }
    update(id, key, value, cart) {
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id == id) {
                cart[i][key] = value
            }
        }
    }
    remove(productID) {
        let cart = this.get()
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id == productID) {
                cart.splice(i, 1)
            }
        }
        this.clear()
        localStorage.setItem('cart', JSON.stringify(cart))
        console.log('data', localStorage.getItem('cart'))
    }
    set(productID, qty, totalPay, action) {
        if (qty == 0) {
            console.log(`removing ${productID}`)
            this.remove(productID)
        }
        let data = []
        let cart = this.get()
        if (cart != null) {
            for (let i = 0; i < cart.length; i++) {
                data.push(cart[i])
            }
        }
        let isDataExists = this.dataExists(productID, data)
        if (isDataExists) {
            this.update(productID, 'qty', qty, data)
            this.update(productID, 'totalPay', totalPay, data)
        }else {
            data.push({
                id: productID,
                qty: qty,
                totalPay: totalPay
            })
        }
        localStorage.setItem('cart', JSON.stringify(data))
        this.showTotalPay()
        return this.get()
    }
    clear() {
        console.log('clearing storage')
        localStorage.clear()
        return this.get()
    }
}

let cart = new Cart()