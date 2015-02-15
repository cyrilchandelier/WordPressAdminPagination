<?php

namespace CC;

/**
 * Generate and display WordPress style admin pagination
 * for use in themes and plugins
 *
 * This pagination is inspired by WordPress Core admin pagination,
 * source can be found in `class-wp-list-table.php`
 *
 * @version 1.0.0
 * @author Cyril Chandelier
 */
class WordPressAdminPagination
{
    /**
     * Total number of items to display in the pagination component
     */
    public $totalItems = 0;

    /**
     * Max number of items per page, default is 25
     */
    public $limit = 25;

    /**
     * Name of URL parameter to determine current page
     */
    public $parameter = "paged";

    /**
     * Output to be displayed, automatically generated once
     */
    private $output = null;

    /**
     * Extract current page based on URL, default is 1
     *
     * @return int
     */
    public function currentPage()
    {
        return isset($_GET[$this->parameter]) && is_numeric($_GET[$this->parameter]) ? $_GET[$this->parameter] : 1;
    }

    /**
     * Compute output if it has not been generated yet
     */
    private function computeOutputIfNeeded()
    {
        if ($this->output != null)
            return;

        $pageLinks = array();
        $currentPage = $this->currentPage();
        $currentUrl = set_url_scheme('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $totalPages = ceil($this->totalItems / $this->limit);

        // Display total number of items
        $output = '<span class="displaying-num">'.sprintf(_n('1 item', '%s items', $this->totalItems), number_format_i18n($this->totalItems)).'</span>';

        // Displat first pages links
        $disableFirst = ($currentPage == 1) ? ' disabled' : '';
        $pageLinks[] = sprintf("<a class='%s' title='%s' href='%s'>%s</a>",
            'first-page'.$disableFirst,
            esc_attr__('Go to the first page'),
            esc_url(remove_query_arg($this->parameter, $currentUrl)),
            '&laquo;'
        );
        $pageLinks[] = sprintf("<a class='%s' title='%s' href='%s'>%s</a>",
            'prev-page'.$disableFirst,
            esc_attr__('Go to the previous page'),
            esc_url(add_query_arg($this->parameter, max(1, $currentPage - 1), $currentUrl)),
            '&lsaquo;'
        );

        // Display current page over total number of pages
        $pageLinks[] = '<span class="paging-input">'.sprintf(_x('%1$s of %2$s', 'paging'), $currentPage, $totalPages).'</span>';

        // Display last pages links
        $disableLast = ($currentPage == $totalPages) ? ' disabled' : '';
        $pageLinks[] = sprintf("<a class='%s' title='%s' href='%s'>%s</a>",
            'next-page'.$disableLast,
            esc_attr__('Go to the next page'),
            esc_url(add_query_arg($this->parameter, min($totalPages, $currentPage + 1), $currentUrl)),
            '&rsaquo;'
        );
        $pageLinks[] = sprintf("<a class='%s' title='%s' href='%s'>%s</a>",
            'last-page'.$disableLast,
            esc_attr__('Go to the last page'),
            esc_url(add_query_arg($this->parameter, $totalPages, $currentUrl)),
            '&raquo;'
        );

        // Compound page links
        $output .= "\n<span class='pagination-links'>".join("\n", $pageLinks).'</span>';

        // Pagination block will be hidden if there is only one page to display
        if ($totalPages) {
            $pageClass = $totalPages < 2 ? ' one-page' : '';
        } else {
            $pageClass = ' no-pages';
        }

        $this->output = "<div class='tablenav-pages{$pageClass}'>$output</div>";
    }

    /**
     * Display the pagination
     */
    public function show()
    {
        $this->computeOutputIfNeeded();
        echo $this->output;
    }
}