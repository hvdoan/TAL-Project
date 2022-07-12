<main id="validate-account">
    <section>
        <?php if ($this->data["activation"]): ?>
            <h1>Votre adresse mail à bien été validé.</h1>
            <p>Activation du compte avec succès.</p>
        <?php else: ?>
            <h1>Une erreur s'est produite.</h1>
            <p>Activation du compte impossible.</p>
        <?php endif; ?>
    </section>
</main>