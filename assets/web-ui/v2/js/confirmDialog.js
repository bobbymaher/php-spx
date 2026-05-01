/* SPX - A seamless profiler for PHP
 * Copyright (C) 2017-2026 Sylvain Lassaut <NoiseByNorthwest@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

let el = null;
let titleEl = null;
let messageEl = null;
let confirmBtn = null;
let cancelBtn = null;

function init() {
    if (el) return;

    el = document.createElement('dialog');
    el.id = 'confirm-dialog';
    el.innerHTML = `
        <div id="confirm-dialog-title"></div>
        <div id="confirm-dialog-message"></div>
        <div id="confirm-dialog-actions">
            <button id="confirm-dialog-cancel">No</button><!--
            --><button id="confirm-dialog-confirm">Delete</button>
        </div>
    `;
    document.body.appendChild(el);

    titleEl = el.querySelector('#confirm-dialog-title');
    messageEl = el.querySelector('#confirm-dialog-message');
    confirmBtn = el.querySelector('#confirm-dialog-confirm');
    cancelBtn = el.querySelector('#confirm-dialog-cancel');
}

export function confirm(title, message) {
    init();

    return new Promise((resolve) => {
        titleEl.textContent = title;
        messageEl.innerHTML = message;
        el.showModal();

        const cleanup = (value) => {
            el.close();
            confirmBtn.removeEventListener('click', onConfirm);
            cancelBtn.removeEventListener('click', onCancel);
            el.removeEventListener('cancel', onCancel);
            resolve(value);
        };

        const onConfirm = () => cleanup(true);
        const onCancel = (e) => {
            e.preventDefault();
            cleanup(false);
        };

        confirmBtn.addEventListener('click', onConfirm);
        cancelBtn.addEventListener('click', onCancel);
        el.addEventListener('cancel', onCancel);
    });
}
