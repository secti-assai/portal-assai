<!DOCTYPE html>
<html>
<head><title>Novo Contato</title></head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <h2>Nova mensagem recebida pelo Portal Municipal</h2>
    <p><strong>Nome:</strong> {{ $dados['nome'] }}</p>
    <p><strong>E-mail:</strong> {{ $dados['email'] }}</p>
    <p><strong>Assunto:</strong> {{ $dados['assunto'] }}</p>
    <hr>
    <p><strong>Mensagem:</strong></p>
    <p>{!! nl2br(e($dados['mensagem'])) !!}</p>
</body>
</html>