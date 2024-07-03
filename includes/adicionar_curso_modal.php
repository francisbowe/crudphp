<!-- adicionar_curso_modal.php -->
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="addCursoLabel">Adicionar Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="adicionar_curso.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Curso</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração (em horas)</label>
                <input type="number" class="form-control" id="duracao" name="duracao" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar Curso</button>
            </div>
        </form>
    </div>
</div>
