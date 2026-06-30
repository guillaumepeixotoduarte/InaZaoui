<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* admin/user/index.html.twig */
class __TwigTemplate_226790bf6cb228d0adfe48966fd738ce extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'admin' => [$this, 'block_admin'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "admin.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/user/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/user/index.html.twig"));

        $this->parent = $this->load("admin.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_admin(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "admin"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "admin"));

        // line 4
        yield "    <div class=\"d-flex justify-content-between align-items-center\">
        <h2 class=\"page-title fs-1\">Invités</h2>
        <a href=\"";
        // line 6
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_add");
        yield "\" class=\"btn btn-primary\">Ajouter</a>
    </div>
    <table class=\"table admin-user-table\">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            ";
        // line 17
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["users"]) || array_key_exists("users", $context) ? $context["users"] : (function () { throw new RuntimeError('Variable "users" does not exist.', 17, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 18
            yield "                <tr>
                    <td>";
            // line 19
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "name", [], "any", false, false, false, 19), "html", null, true);
            yield "</td>
                    <td>";
            // line 20
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 20), "html", null, true);
            yield "</td>
                    <td>
                        <a href=\"";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 22)]), "html", null, true);
            yield "\" class=\"btn btn-danger delete-user\">Supprimer</a>
                        <a href=\"";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_switch_access", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 23)]), "html", null, true);
            yield "\" class=\"btn ";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "active", [], "any", false, false, false, 23)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("btn-secondary") : ("btn-success"));
            yield " deactivate-user\">";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "active", [], "any", false, false, false, 23)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Désactiver") : ("Activer"));
            yield "</a>
                    </td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['user'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        yield "        </tbody>
    </table>
    ";
        // line 29
        $context["totalPages"] = Twig\Extension\CoreExtension::round(((isset($context["total"]) || array_key_exists("total", $context) ? $context["total"] : (function () { throw new RuntimeError('Variable "total" does not exist.', 29, $this->source); })()) / 25), 0, "ceil");
        // line 30
        yield "
    <nav aria-label=\"Page navigation\">
        <ul class=\"pagination\">
            ";
        // line 33
        if (((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 33, $this->source); })()) > 1)) {
            // line 34
            yield "                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 35
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_index", ["page" => 1]);
            yield "\">Première page</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_index", ["page" => ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 38, $this->source); })()) - 1)]), "html", null, true);
            yield "\">Précédent</a>
                </li>
            ";
        }
        // line 41
        yield "
            ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(max(1, ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 42, $this->source); })()) - 3)), min((isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 42, $this->source); })()), ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 42, $this->source); })()) + 3))));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 43
            yield "                <li class=\"page-item ";
            if (($context["i"] == (isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 43, $this->source); })()))) {
                yield "active";
            }
            yield "\">
                    <a class=\"page-link\" href=\"";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_index", ["page" => $context["i"]]), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
            yield "</a>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        yield "
            ";
        // line 48
        if (((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 48, $this->source); })()) < (isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 48, $this->source); })()))) {
            // line 49
            yield "                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 50
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_index", ["page" => ((isset($context["page"]) || array_key_exists("page", $context) ? $context["page"] : (function () { throw new RuntimeError('Variable "page" does not exist.', 50, $this->source); })()) + 1)]), "html", null, true);
            yield "\">Suivant</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_user_index", ["page" => (isset($context["totalPages"]) || array_key_exists("totalPages", $context) ? $context["totalPages"] : (function () { throw new RuntimeError('Variable "totalPages" does not exist.', 53, $this->source); })())]), "html", null, true);
            yield "\">Dernière page</a>
                </li>
            ";
        }
        // line 56
        yield "        </ul>
    </nav>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/user/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  201 => 56,  195 => 53,  189 => 50,  186 => 49,  184 => 48,  181 => 47,  170 => 44,  163 => 43,  159 => 42,  156 => 41,  150 => 38,  144 => 35,  141 => 34,  139 => 33,  134 => 30,  132 => 29,  128 => 27,  114 => 23,  110 => 22,  105 => 20,  101 => 19,  98 => 18,  94 => 17,  80 => 6,  76 => 4,  63 => 3,  40 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \x27admin.html.twig\x27 %}

{% block admin %}
    <div class=\"d-flex justify-content-between align-items-center\">
        <h2 class=\"page-title fs-1\">Invités</h2>
        <a href=\"{{ path(\x27admin_user_add\x27) }}\" class=\"btn btn-primary\">Ajouter</a>
    </div>
    <table class=\"table admin-user-table\">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
                <tr>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <a href=\"{{ path(\x27admin_user_delete\x27, {id: user.id}) }}\" class=\"btn btn-danger delete-user\">Supprimer</a>
                        <a href=\"{{ path(\x27admin_user_switch_access\x27, {id: user.id}) }}\" class=\"btn {{ user.active ? \x27btn-secondary\x27 : \x27btn-success\x27 }} deactivate-user\">{{ user.active ? \x27Désactiver\x27 : \x27Activer\x27 }}</a>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
    {% set totalPages = (total / 25)|round(0, \x27ceil\x27) %}

    <nav aria-label=\"Page navigation\">
        <ul class=\"pagination\">
            {% if page > 1 %}
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_user_index\x27, {page: 1}) }}\">Première page</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_user_index\x27, {page: page - 1}) }}\">Précédent</a>
                </li>
            {% endif %}

            {% for i in range(max(1, page - 3), min(totalPages, page + 3)) %}
                <li class=\"page-item {% if i == page %}active{% endif %}\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_user_index\x27, {page: i}) }}\">{{ i }}</a>
                </li>
            {% endfor %}

            {% if page < totalPages %}
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_user_index\x27, {page: page + 1}) }}\">Suivant</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"{{ path(\x27admin_user_index\x27, {page: totalPages}) }}\">Dernière page</a>
                </li>
            {% endif %}
        </ul>
    </nav>
{% endblock %}", "admin/user/index.html.twig", "C:\\wamp64\\www\\876-p15-inazaoui-main\\templates\\admin\\user\\index.html.twig");
    }
}
