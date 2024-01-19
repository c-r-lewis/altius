<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Calendrier des évènements</title>

    <meta charset="utf-8">
    <link rel="icon" href="/assets/images/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/css/evo-calendar.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/evo-calendar.royal-navy.css">

</head>
<body>
    <header>
    </header>

    <main>
        <div id="calendar"></div>
    </main>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="/assets/js/evo-calendar.js"></script>

    <!-- Script pour loader le calendrier -->
    <script>
        $(document).ready(function() {
            $('#calendar').evoCalendar({
                'language': 'fr',
                'theme': 'Royal Navy',
                'format': 'MM dd, yyyy'
            });
        })
    </script>
</body>
</html>