# 💻 DevMatrix Innovations

**DevMatrix Innovations** é uma empresa fictícia criada como parte do Trabalho de Conclusão de Curso Técnico em Informática para Internet.  
O projeto consiste no desenvolvimento de uma **plataforma web profissional** que conecta empresas que precisam de serviços de tecnologia da informação a profissionais qualificados — como desenvolvedores, analistas de dados, técnicos em hardware, entre outros.

Diferente de redes sociais como o LinkedIn, a DevMatrix tem um foco direto e funcional: **conectar empresas a profissionais de TI sob demanda**, por meio de uma **contratação terceirizada supervisionada por um administrador interno**.

---

## 🎯 Objetivo do Sistema

Criar uma plataforma **interativa** e **responsiva** que possibilite:

- 🏢 Empresas (grandes ou pequenas, como McDonald's, brechós e lanchonetes) solicitarem serviços de TI.
- 👨‍💻 Alocação de profissionais adequados pela DevMatrix para atender as demandas.
- 🧪 Profissionais passarem por testes técnicos antes de integrar a equipe.
- 🧑‍💼 Um administrador interno cadastrar atividades, atribuir tarefas e gerenciar usuários.

---

## 🚀 Funcionalidades Principais

- ✅ Interface responsiva (funciona em celulares e desktops)
- ✅ Cadastro e login de empresas e profissionais
- ✅ Sistema de candidatura e testes práticos
- ✅ Gerenciamento de tarefas e atividades
- ✅ Atribuição de demandas por um administrador
- ✅ Níveis de acesso distintos:

  - **Administrador (Nível 1):** Gerencia usuários, tarefas e o sistema.
  - **Usuário comum (Nível 0):** Se candidata a vagas e realiza tarefas atribuídas.

---

## 🛠️ Começando o Projeto

### 📥 1. Clonar o repositório

```bash
git clone https://github.com/HiagoDaRocha/DevMatrix-Innovations.git
```

### ⚙️ 2. Configurar variáveis de ambiente

Crie um arquivo `.env` com base no `.env.example`, preenchendo com os valores adequados (como credenciais, portas e chaves necessárias).


### 🧹 3. Remover arquivos temporários

Exclua os arquivos `apagar.txt` nas seguintes pastas:

- `uploads/`
- `uploadsImages/`

> Esses arquivos existem apenas para garantir que as pastas vazias sejam enviadas ao Git.


### 🐳 4. Iniciar o Docker do projeto

Iniciar o projeto com: 

```bash
docker-compose up -d --build
```

### ⏹️▶️ 5. Parar e iniciar o Docker

Para parar o ambiente:

```bash
docker compose stop
```
Para iniciar novamente:

```bash
docker compose start
```