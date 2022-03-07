async function fetchInvoices() {
  const response = await fetch("https://localhost:8000/invoice");
  return await response.json();
}
async function fetchInvoiceDetails(id) {
  const response = await fetch(`https://localhost:8000/invoice/details/${id}`)
  return await response.json()
}
/* get invoices data and diplay invoice nodes */
fetchInvoices().then((invoices) => {
  const invoicesContainer = document.getElementById("invoices-list");
  invoices.forEach(invoice => {
    addChildNode(invoicesContainer, createInvoiceNode(invoice))
  })
});

const createInvoiceNode = (invoice = {id: 0, date: null, number: 0, cid: 0}) => {
  const invoiceContainer =  createNode('div');
  const invoiceDate = createNode('p')
  const invoiceNumber = createNode('h2')
  const invoiceCustomerId = createNode('p')
  const detailsContainer = createNode('div')
  const detailsBtn = createNode('button')
  const hideBtn = createNode('button')
  const btnContainer = createNode('div')

  invoiceDate.textContent = `date: ${invoice.date}`;
  invoiceNumber.textContent = `Invoice Number: ${invoice.number}`;
  invoiceCustomerId.textContent = `Customer id: ${invoice.cid}`;
  detailsBtn.setAttribute("class", 'details');
  hideBtn.setAttribute("class", 'hide-btn');
  detailsBtn.setAttribute('data-id', invoice.id)
  detailsBtn.textContent = "Details"
  hideBtn.textContent = "Hide"
  detailsContainer.classList.add('hide')

  detailsBtn.addEventListener('click', function () {
    if (!detailsContainer.classList.contains('invoice-details')) {
      detailsContainer.classList.add('invoice-details')
      detailsContainer.classList.remove('hide')
      showInvoiceDetails(detailsContainer, detailsBtn.dataset.id)
    }
  })
  hideBtn.addEventListener('click', function () {
    detailsContainer.classList.add('hide')
    detailsContainer.classList.remove('invoice-details')
    detailsContainer.querySelectorAll('*').forEach(childNode => childNode.remove())
  })

  addChildrenNodes(btnContainer, [detailsBtn, hideBtn])
  addChildrenNodes(invoiceContainer, [invoiceNumber, invoiceDate, invoiceCustomerId, detailsContainer, btnContainer]);

  return invoiceContainer
}

const createNode = (node) => {
  return document.createElement(node);
}

const addChildNode = (parent, childNode) => {
  parent.appendChild(childNode)
}

const addChildrenNodes = (parent, children) => {
  children.forEach(child => addChildNode(parent, child))
}

/* show invoice details */
const showInvoiceDetails = (container, id) => {
  fetchInvoiceDetails(id).then((details = {description: "", quantity: 0, amount: 0, vat: 0, total: 0}) => {
    const description = createNode('p')
    const quantity = createNode('p')
    const amountAndVat = createNode('p')
    const amount = createNode('span')
    const vat = createNode('span')
    const total = createNode('total')

    description.textContent = `Description: ${details.description}`
    quantity.textContent = `Quantity: ${details.quantity}`
    amount.textContent = `Amount: ${details.amount}`
    vat.textContent = `VAT: ${details.vat}`
    total.textContent = `Total: ${details.total}`

    addChildrenNodes(amountAndVat, [amount, space(), vat])
    addChildrenNodes(container, [description, quantity, amountAndVat, total])
  })
}

const space = () => {
  const s = createNode('span')
  s.textContent = ' '
  return s
}

/* add invoice */
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById("invoiceForm")
      .addEventListener('submit', addInvoice)
})

const addInvoice = async (e) => {
  e.preventDefault()
  let invoiceForm = e.target
  let formData = new FormData(invoiceForm)
  const response = await fetch("https://localhost:8000/invoice/add", {
    method: "POST",
    body: formData,
  })
  const data = await response.json()
  console.log(data)
};