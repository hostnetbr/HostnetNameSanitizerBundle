# Mautic Name Sanitizer
Um plugin do Mautic que faz uma correção e limpeza nos nomes dos contatos cadastrados. Por exemplo: se o contato estiver cadastrado com o primeiro nome como “PEDRO DE JESUS” e o último nome como “Dos Santos”, após a execução do plugin, o campo de primeiro nome ficará “Pedro” e o campo de último nome será alterado para “de Jesus dos Santos”.

### Instalação

Faça o download dos arquivos e zip e extraia. 

Copie a pasta **HostnetNameSanitizerBundle** para a pasta **plugins** na sua instalação do Mautic.

Limpe o cache rodando o seguinte comando na pasta raíz do seu Mautic:

```sh
$ php app/console cache:clear
```
Acessea página de plugins pelo painel do Mautic e clique no botão **Instalar/Atualizar plugins**. 

### Ativação e uso

Procure na listagem de plugins por “Name Sanitizer”, clique nele e depois clique em Sim abaixo de publicado. Salve as alterações e feche.

Após isso, será possível rodar o seguinte comando na na pasta raíz do seu Mautic:

```sh
$ php app/console mautic:sanitize-names
```

Quando executado, o plugin irá pegar todos os nomes de contatos cadastrados no mautic e corrigi-los caso necessário. Após, ele irá retornar o número total de contatos que foram alterados.

## Autor
*  **Pedro de Jesus** - *pedro.jesus@hostnet.com.br*
