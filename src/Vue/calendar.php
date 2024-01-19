
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center p-2">
            <button class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                </svg>
            </button>
            <div class="current-month"></div>
            <button class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="calendar">
        <div class="weekdays d-flex justify-content-between px-1">
            <div class="weekday-name">Dim</div>
            <div class="weekday-name">Lun</div>
            <div class="weekday-name">Mar</div>
            <div class="weekday-name">Mer</div>
            <div class="weekday-name">Jeu</div>
            <div class="weekday-name">Ven</div>
            <div class="weekday-name">Sam</div>
        </div>
        <div class="calendar-days"></div>
    </div>
    <div class="goto-buttons">
        <button type="button" class="btn prev-year">Prev Year</button>
        <button type="button" class="btn today">Today</button>
        <button type="button" class="btn next-year">Next Year</button>
    </div>
</div>
