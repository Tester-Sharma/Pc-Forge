const steps = ['cpu', 'motherboard', 'ram', 'storage', 'gpu', 'psu', 'summary'];
let currentStepIndex = 0;
let selection = {
    cpu: null,
    motherboard: null,
    ram: null,
    storage: null,
    gpu: null,
    psu: null
};

const btnNext = document.getElementById('btn-next');
const btnPrev = document.getElementById('btn-prev');
const budgetInput = document.getElementById('budget-input');
const totalPriceEl = document.getElementById('total-price');
const budgetStatus = document.getElementById('budget-status');
const miniSummary = document.getElementById('mini-summary');

// Initialize
function init() {
    renderStep();
    updateSummary();
    
    btnNext.addEventListener('click', () => {
        if (currentStepIndex < steps.length - 1) {
            currentStepIndex++;
            renderStep();
        }
    });

    btnPrev.addEventListener('click', () => {
        if (currentStepIndex > 0) {
            currentStepIndex--;
            renderStep();
        }
    });

    budgetInput.addEventListener('input', checkBudget);
}

function renderStep() {
    const currentStepSlug = steps[currentStepIndex];
    
    // Hide all steps
    document.querySelectorAll('.builder-step').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.step-indicator').forEach(el => el.classList.remove('active-step'));

    // Show current step
    const stepEl = document.getElementById(`step-${currentStepSlug}`);
    if (stepEl) stepEl.classList.add('active');
    
    // Update indicators
    for (let i = 0; i <= currentStepIndex; i++) {
        if (i < steps.length - 1) { 
             const ind = document.getElementById(`step-indicator-${steps[i]}`);
             if (ind) {
                 ind.classList.add('active-step');
             }
        }
    }

    // Button states
    btnPrev.style.visibility = currentStepIndex === 0 ? 'hidden' : 'visible';
    
    if (currentStepSlug === 'summary') {
        btnNext.style.display = 'none';
        renderFinalSummary();
    } else {
        btnNext.style.display = 'inline-block';
        // Check if selection exists for this step to enable Next
        if (selection[currentStepSlug]) {
            btnNext.disabled = false;
        } else {
            btnNext.disabled = true;
        }
        renderPartsList(currentStepSlug);
    }
}

function renderPartsList(categorySlug) {
    const container = document.getElementById(`list-${categorySlug}`);
    container.innerHTML = '';

    let parts = partsData[categorySlug] || [];

    // Filter parts based on compatibility
    parts = parts.filter(part => isCompatible(categorySlug, part));

    if (parts.length === 0) {
        container.innerHTML = '<div class="p-3 text-center">No compatible parts found based on previous selections.</div>';
        return;
    }

    parts.forEach(part => {
        const el = document.createElement('div');
        el.className = `part-item ${selection[categorySlug] && selection[categorySlug].id === part.id ? 'selected' : ''}`;
        el.innerHTML = `
            <div>
                <div style="font-weight: bold;">${part.brand} ${part.name}</div>
                <div style="font-size: 0.9rem; color: #586069;">${getSpecsString(part)}</div>
            </div>
            <div class="price-tag">₹${parseFloat(part.price).toLocaleString()}</div>
        `;
        el.addEventListener('click', () => selectPart(categorySlug, part));
        container.appendChild(el);
    });
}

function getSpecsString(part) {
    let specs = [];
    if (part.socket_type) specs.push(part.socket_type);
    if (part.ram_type) specs.push(part.ram_type);
    if (part.form_factor) specs.push(part.form_factor);
    if (part.wattage) specs.push(`${part.wattage}W`);
    if (part.interface) specs.push(part.interface);
    if (part.min_psu_wattage) specs.push(`Min PSU: ${part.min_psu_wattage}W`);
    return specs.join(' • ');
}

function isCompatible(category, part) {
    if (category === 'motherboard') {
        if (selection.cpu && part.socket_type !== selection.cpu.socket_type) return false;
    }
    if (category === 'ram') {
        if (selection.motherboard && part.ram_type !== selection.motherboard.ram_type) return false;
    }
    if (category === 'psu') {
        if (selection.gpu && part.wattage < selection.gpu.min_psu_wattage) return false;
    }
    return true;
}

function selectPart(category, part) {
    // Check if changing upstream part invalidates downstream
    if (category === 'cpu' && selection.cpu && selection.cpu.id !== part.id) {
        selection.motherboard = null;
        selection.ram = null;
    }
    if (category === 'motherboard' && selection.motherboard && selection.motherboard.id !== part.id) {
        selection.ram = null;
    }
    if (category === 'gpu' && selection.gpu && selection.gpu.id !== part.id) {
        selection.psu = null;
    }

    selection[category] = part;
    renderStep(); // Re-render to update selection UI and potentially clear invalid future steps
    updateSummary();
}

function updateSummary() {
    let total = 0;
    miniSummary.innerHTML = '';

    steps.forEach(step => {
        if (step === 'summary') return;
        const part = selection[step];
        if (part) {
            total += parseFloat(part.price);
            const li = document.createElement('li');
            li.style.marginBottom = '0.5rem';
            li.innerHTML = `
                <div style="font-size: 0.8rem; color: #586069; text-transform: uppercase;">${step}</div>
                <div style="display: flex; justify-content: space-between;">
                    <span>${part.model || part.name}</span>
                    <span>₹${parseFloat(part.price).toLocaleString()}</span>
                </div>
            `;
            miniSummary.appendChild(li);
        }
    });

    totalPriceEl.textContent = total.toLocaleString();
    checkBudget(total);
}

function checkBudget(currentTotal) {
    // If called from event listener, calculate total again
    let total = 0;
    Object.values(selection).forEach(p => { if(p) total += parseFloat(p.price); });
    
    const budget = parseFloat(budgetInput.value);
    if (budget && total > budget) {
        budgetStatus.style.display = 'block';
        totalPriceEl.style.color = '#d73a49';
    } else {
        budgetStatus.style.display = 'none';
        totalPriceEl.style.color = '#2dba4e';
    }
}

function renderFinalSummary() {
    const container = document.getElementById('summary-content');
    container.innerHTML = '';
    
    let total = 0;
    const table = document.createElement('table');
    table.className = 'table';
    
    steps.forEach(step => {
        if (step === 'summary') return;
        const part = selection[step];
        if (part) {
            total += parseFloat(part.price);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${step.toUpperCase()}</strong></td>
                <td>${part.brand} ${part.name}</td>
                <td>₹${parseFloat(part.price).toLocaleString()}</td>
            `;
            table.appendChild(tr);
            
            // Populate hidden form inputs
            const input = document.getElementById(`input-${step}`);
            if (input) input.value = part.id;
        }
    });
    
    container.appendChild(table);
    
    const totalDiv = document.createElement('div');
    totalDiv.className = 'text-center mt-2';
    totalDiv.innerHTML = `<h3>Total Build Cost: <span style="color: var(--color-primary);">₹${total.toLocaleString()}</span></h3>`;
    container.appendChild(totalDiv);

    // Populate form totals
    document.getElementById('input-total').value = total;
    document.getElementById('input-budget').value = budgetInput.value;
}

init();